<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Vérifier que le formulaire a été soumis via POST et qu'il contient les données attendues
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['name'])) {
    // Rediriger vers la page de devis si accès direct
    echo "<script>window.location.href = 'devis.php';</script>";
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

// Clé secrète reCAPTCHA
$recaptcha_secret = '6LeifvgrAAAAABgfZ12Bg714Codw410GaOxKS3QS';

// Fonction de nettoyage
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // --- Initialisation du Rate Limiter ---
    $conn = get_db_connection($config);
    if ($conn === null) {
        echo "<script>alert('❌ Erreur de connexion à la base de données.');window.location.href='devis.php';</script>";
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
        $rateCheck = $rateLimiter->canSubmit('devis');
        if (!$rateCheck['allowed']) {
            $rateLimiter->recordAttempt('devis', false);
            
            if ($rateCheck['reason'] === 'IP blacklistée') {
                echo "<script>
                    alert('🚫 Votre IP a été temporairement bloquée pour activité suspecte.');
                    window.location.href = 'devis.php';
                </script>";
            } else {
                $retry_time = date('H:i', $rateCheck['retry_after']);
                echo "<script>
                    alert('⏰ Trop de tentatives détectées.\\n\\nVous pourrez réessayer après {$retry_time}.\\n\\nTentatives: {$rateCheck['attempts']}/{$rateCheck['max_attempts']}');
                    window.location.href = 'devis.php';
                </script>";
            }
            exit;
        }
    }

    // Récupération et nettoyage des champs
    $name          = clean_input($_POST["name"] ?? "");
    $email         = clean_input($_POST["email"] ?? "");
    $confirm_email = clean_input($_POST["confirm_email"] ?? "");
    $phone         = clean_input($_POST["phone"] ?? "");
    $address       = clean_input($_POST["address"] ?? "");
    $project_type  = clean_input($_POST["project_type"] ?? "");
    $surface       = clean_input($_POST["surface"] ?? "");
    $deadline      = clean_input($_POST["deadline"] ?? "");
    $budget        = clean_input($_POST["budget"] ?? "");
    $details       = clean_input($_POST["details"] ?? "");
    $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';

    // --- Vérification reCAPTCHA ---
    if (empty($recaptcha_response)) {
        $rateLimiter->recordAttempt('devis', false);
        echo "<script>
            alert('⚠️ Erreur reCAPTCHA : Veuillez cocher la case \"Je ne suis pas un robot\".');
            window.location.href = 'devis.php';
        </script>";
        exit;
    }

    $verify_response = file_get_contents(
        "https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}"
    );
    $response_data = json_decode($verify_response);

    if (!$response_data->success) {
        $rateLimiter->recordAttempt('devis', false);
        $error_codes = isset($response_data->{'error-codes'}) ? implode(', ', $response_data->{'error-codes'}) : 'Unknown error';
        echo "<script>
            alert('❌ Échec de la vérification reCAPTCHA. Veuillez réessayer.\\nCode d\\'erreur: {$error_codes}');
            window.location.href = 'devis.php';
        </script>";
        exit;
    }

    // --- Validation des emails ---
    if ($email !== $confirm_email) {
        echo "<script>
            alert('⚠️ Les adresses e-mail ne correspondent pas.');
            window.location.href = 'devis.php';
        </script>";
        exit;
    }

    // --- Validation des champs obligatoires ---
    if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($project_type) || empty($details)) {
        echo "<script>
            alert('⚠️ Veuillez remplir tous les champs obligatoires.');
            window.location.href = 'devis.php';
        </script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
            alert('❌ Adresse e-mail invalide.');
            window.location.href = 'devis.php';
        </script>";
        exit;
    }

    // Dossier d'upload
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0775, true);

    // Gestion des fichiers joints
    $attachments = [];
    if (!empty($_FILES['attachment']['name'][0])) {
        foreach ($_FILES['attachment']['name'] as $key => $filename) {
            $tmpName = $_FILES['attachment']['tmp_name'][$key];
            $error = $_FILES['attachment']['error'][$key];
            if ($error === UPLOAD_ERR_OK) {
                $safeName = time() . "_" . basename($filename);
                $destination = $uploadDir . $safeName;
                if (move_uploaded_file($tmpName, $destination)) {
                    $attachments[] = $destination;
                }
            }
        }
    }

    // Enregistrer dans la base MySQL
    $conn = get_db_connection($config);
    if ($conn === null) {
        echo "<script>
            alert('❌ Erreur de connexion à la base de données. Veuillez réessayer plus tard.');
            window.location.href = 'devis.php';
        </script>";
        exit;
    }
    
    $attachmentsList = implode(',', $attachments);
    $stmt = $conn->prepare("
        INSERT INTO devis_requests 
        (name, email, phone, address, project_type, surface, deadline, budget, details, attachments) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "sssssdssss",
        $name,
        $email,
        $phone,
        $address,
        $project_type,
        $surface,
        $deadline,
        $budget,
        $details,
        $attachmentsList
    );

    if (!$stmt->execute()) {
        echo "<script>
            alert('⚠️ Erreur d\\'enregistrement : " . addslashes($stmt->error) . "');
            window.location.href = 'devis.php';
        </script>";
        exit;
    }

    // Envoi d’un email de notification
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $config['email']; // ton email d’expédition
        $mail->Password = 'iofz ixfb gvtr gohj'; // ⚠️ mot de passe d’application Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($config['email'], $config['site_name']);
        $mail->addAddress($config['email'], "Service Devis");

        foreach ($attachments as $filePath) {
            $mail->addAttachment($filePath);
        }

        $mail->isHTML(true);
        $mail->Subject = "Nouvelle demande de devis - " . $config['site_name'];
        $mail->Body = "
        <h2>Nouvelle demande de devis</h2>
        <p><strong>Nom :</strong> $name</p>
        <p><strong>Email :</strong> $email</p>
        <p><strong>Téléphone :</strong> $phone</p>
        <p><strong>Adresse :</strong> $address</p>
        <p><strong>Type de projet :</strong> $project_type</p>
        <p><strong>Surface :</strong> {$surface} m²</p>
        <p><strong>Délai :</strong> $deadline</p>
        <p><strong>Budget :</strong> $budget USD</p>
        <p><strong>Description :</strong><br>$details</p>
        <p><strong>Fichiers joints :</strong> " . (empty($attachments) ? "Aucun" : implode(", ", array_map('basename', $attachments))) . "</p>
        ";

        $mail->send();

        // Enregistrer la tentative réussie
        $rateLimiter->recordAttempt('devis', true);

     echo '
<div style="
    max-width:600px;
    margin:60px auto;
    background:#f9f9f9;
    border-radius:16px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
    padding:40px;
    text-align:center;
    font-family:Arial, sans-serif;
">
    <img src="assets/images/CIC-LOGO-VERSION-FINAL.jpg" alt="Logo" style="width:120px;margin-bottom:20px;">
    <h2 style="color:#0b3d91;margin-bottom:10px;">Votre demande de devis a bien été envoyée ✅</h2>
    <p style="color:#333;font-size:16px;line-height:1.6;">
        Merci <strong>' . htmlspecialchars($name) . '</strong> !<br>
        Nous avons bien reçu votre demande. Notre équipe vous répondra dans un délai de <strong>48 heures ouvrées</strong>.
    </p>
    <div style="margin:30px 0;">
        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#0b3d91" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
    </div>
    <a href="index.php" style="
        display:inline-block;
        background:#0b3d91;
        color:white;
        text-decoration:none;
        padding:12px 24px;
        border-radius:8px;
        font-weight:bold;
        transition:background 0.3s;
    " onmouseover="this.style.background=\'#092b6b\'" onmouseout="this.style.background=\'#0b3d91\'">
        ← Retour à l’accueil
    </a>
    <p style="margin-top:20px;color:#777;font-size:13px;">
        © ' . date("Y") . ' ' . htmlspecialchars($config["site_name"]) . ' — Tous droits réservés.
    </p>
</div>';

    } catch (Exception $e) {
        $rateLimiter->recordAttempt('devis', false);
        echo "<h3 style='color:red;text-align:center;'>❌ L'email n'a pas pu être envoyé : {$mail->ErrorInfo}</h3>";
    }

    $stmt->close();
    $conn->close();

} else {
    echo "Méthode non autorisée.";
}
?>
