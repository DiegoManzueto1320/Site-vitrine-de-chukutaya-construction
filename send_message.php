<?php

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\Exception;



// Vérifier que le formulaire a été soumis via POST et qu'il contient les données attendues

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['name'])) {

    // Rediriger vers la page de contact si accès direct

    echo "<script>window.location.href = 'contact.php';</script>";

    exit;

}



// Charger la configuration et la connexion MySQL

$config = include __DIR__ . '/config.php';

require 'phpmailer/src/Exception.php';

require 'phpmailer/src/PHPMailer.php';

require 'phpmailer/src/SMTP.php';



// Charger RateLimiter avec vérification et fallback

if (!class_exists('RateLimiter')) {

    $rate_limiter_path = __DIR__ . '/RateLimiter.php';

    if (file_exists($rate_limiter_path)) {

        require_once $rate_limiter_path;

    }

    

    // Si RateLimiter ne se charge pas, utiliser la version simple

    if (!class_exists('RateLimiter') && file_exists(__DIR__ . '/RateLimiterSimple.php')) {

        require_once __DIR__ . '/RateLimiterSimple.php';

        class_alias('RateLimiterSimple', 'RateLimiter');

    }

}




// Traitement du formulaire

if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    // --- Initialisation du Rate Limiter ---

    $conn = get_db_connection($config);

    if ($conn === null) {

        echo "<script>alert('❌ Erreur de connexion à la base de données.');window.location.href='contact.php';</script>";

        exit;

    }

    

    // Créer RateLimiter seulement si la classe existe

    $rateLimiter = null;

    if (class_exists('RateLimiter')) {

        try {

            $rateLimiter = new RateLimiter($conn, $config);

        } catch (Exception $e) {

            error_log("Erreur création RateLimiter: " . $e->getMessage());

            // Essayer avec la version simple

            if (class_exists('RateLimiterSimple')) {

                $rateLimiter = new RateLimiterSimple($conn);

            }

        }

    } elseif (class_exists('RateLimiterSimple')) {

        $rateLimiter = new RateLimiterSimple($conn);

    }

    

    // --- Vérification Rate Limiting ---

    if ($rateLimiter !== null) {

        $rateCheck = $rateLimiter->canSubmit('contact');

        if (!$rateCheck['allowed']) {

            $rateLimiter->recordAttempt('contact', false);

            

            if ($rateCheck['reason'] === 'IP blacklistée') {

                echo "<script>

                    alert('🚫 Votre IP a été temporairement bloquée pour activité suspecte.');

                    window.location.href = 'contact.php';

                </script>";

            } else {

                $retry_time = date('H:i', $rateCheck['retry_after']);

                echo "<script>

                    alert('⏰ Trop de tentatives détectées.\\n\\nVous pourrez réessayer après {$retry_time}.\\n\\nTentatives: {$rateCheck['attempts']}/{$rateCheck['max_attempts']}');

                    window.location.href = 'contact.php';

                </script>";

            }

            exit;

        }

    }



    // --- Sécurisation des entrées ---

    $name    = trim(htmlspecialchars($_POST['name'] ?? ''));

    $email   = trim(htmlspecialchars($_POST['email'] ?? ''));

    $phone   = trim(htmlspecialchars($_POST['phone'] ?? ''));

    $subject = trim(htmlspecialchars($_POST['subject'] ?? ''));

    $message = trim(htmlspecialchars($_POST['message'] ?? ''));

    $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';



   
    }



    $verify_response = file_get_contents(

        "https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}"

    );

    $response_data = json_decode($verify_response);



    if (!$response_data->success) {

        if ($rateLimiter) $rateLimiter->recordAttempt('contact', false);

        $error_codes = isset($response_data->{'error-codes'}) ? implode(', ', $response_data->{'error-codes'}) : 'Unknown error';

        echo "<script>

            alert('❌ Échec de la vérification reCAPTCHA. Veuillez réessayer.\\nCode d\\'erreur: {$error_codes}');

            window.location.href = 'contact.php';

        </script>";

        exit;

    }



    // --- Validation basique ---

    if (empty($name) || empty($email) || empty($phone) || empty($subject) || empty($message)) {

        if ($rateLimiter) $rateLimiter->recordAttempt('contact', false);

        echo "<script>alert('⚠️ Veuillez remplir tous les champs obligatoires.');window.location.href='contact.php';</script>";

        exit;

    }



    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        if ($rateLimiter) $rateLimiter->recordAttempt('contact', false);

        echo "<script>alert('❌ Adresse e-mail invalide.');window.location.href='contact.php';</script>";

        exit;

    }



    // --- Enregistrement du message dans la base de données ---

    // Note: $conn est déjà initialisé plus haut pour le RateLimiter



    try {

        $stmt = $conn->prepare("

            INSERT INTO contacts (name, email, phone, subject, message)

            VALUES (?, ?, ?, ?, ?)

        ");

        $stmt->execute([$name, $email, $phone, $subject, $message]);

    } catch (Exception $e) {

        echo "<script>alert('⚠️ Erreur base de données : {$e->getMessage()}');window.history.back();</script>";

        exit;

    }



    // --- Envoi d’e-mail ---

    $mail = new PHPMailer(true);



    try {

        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';

        $mail->SMTPAuth = true;

        $mail->Username = $config['email']; // ton adresse Gmail

        $mail->Password = 'uebe vtvg lktm ld hr'; // mot de passe d’application Gmail

        $mail->SMTPSecure = 'tls';

        $mail->Port = 587;



        // Expéditeur et destinataire

        $mail->setFrom('contact@tonentreprise.com', 'Formulaire du site web');

        $mail->addReplyTo($email, $name);

        $mail->addAddress('chekinvest.cd@gmail.com', 'CIC Construction');



        // Contenu du message

        $mail->isHTML(true);

        $mail->Subject = "📩 Nouveau message de contact - {$subject}";

        $mail->Body = "

            <html><body style='font-family: Arial, sans-serif;'>

                <h3 style='color:#0b3d91;'>Nouveau message via le site web</h3>

                <p><strong>Nom :</strong> {$name}</p>

                <p><strong>Email :</strong> {$email}</p>

                <p><strong>Téléphone :</strong> {$phone}</p>

                <p><strong>Sujet :</strong> {$subject}</p>

                <p><strong>Message :</strong><br>" . nl2br($message) . "</p>

                <hr>

                <small style='color:#888;'>Message envoyé depuis le site web EJC Construction</small>

            </body></html>

        ";



        $mail->send();



        // Enregistrer la tentative réussie

        if ($rateLimiter) $rateLimiter->recordAttempt('contact', true);



        echo "<script>

            alert('✅ Merci {$name} ! Votre message a bien été envoyé.\\nNous vous répondrons très prochainement.');

            window.location='contact.php';

        </script>";



    } catch (Exception $e) {

        if ($rateLimiter) $rateLimiter->recordAttempt('contact', false);

        echo "<script>

            alert('❌ L'e-mail n'a pas pu être envoyé : {$mail->ErrorInfo}');

            window.location='contact.php';

        </script>";

    }

}

?>

