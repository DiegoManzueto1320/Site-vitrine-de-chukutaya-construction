<?php
// functions.php
if (!isset($config) || !is_array($config)) {
    $config = include_once __DIR__ . '/config.php';
}

// Simple système multilingue via paramètre GET ?lang=fr|en (par défaut fr)
function lang() {
    $allowed = ['fr','en'];
    if(isset($_GET['lang']) && in_array($_GET['lang'],$allowed)) return $_GET['lang'];
    return 'fr';
}

function t($key) {
    $l = lang();
    $translations = [
        'fr' => [
            'home' => 'Accueil',
            'about' => 'À propos',
            'services' => 'Services',
            'realisations' => 'Réalisations',
            'contact' => 'Contact',
            'send_message' => 'Envoyer',
            'name' => 'Nom complet',
            'email' => 'Email',
            'phone' => 'Téléphone',
            'message' => 'Message',
            'request_quote' => 'Demander un devis',
            'address' => 'Adresse',
            'follow_us' => 'Suivez-nous',
            'see_more' => 'Voir plus',
            'thank_you' => 'Merci ! Votre message a été envoyé.',
            'error' => 'Une erreur est survenue. Réessayez plus tard.',
        ],
        'en' => [
            'home' => 'Home',
            'about' => 'About',
            'services' => 'Services',
            'realisations' => 'Projects',
            'contact' => 'Contact',
            'send_message' => 'Send',
            'name' => 'Full name',
            'email' => 'Email',
            'phone' => 'Phone',
            'message' => 'Message',
            'request_quote' => 'Request a quote',
            'address' => 'Address',
            'follow_us' => 'Follow us',
            'see_more' => 'See more',
            'thank_you' => 'Thank you! Your message has been sent.',
            'error' => 'An error occurred. Please try again later.',
        ],
    ];
    return $translations[$l][$key] ?? $key;
}

// Helper pour construire URL avec param lang
function url_with_lang($path = '/') {
    $l = lang();
    // If path already has query params, append properly
    if (strpos($path, '?') === false) {
        return $path . '?lang=' . $l;
    } else {
        return $path . '&lang=' . $l;
    }
}

// Fonction d'envoi d'email simple
function send_mail($to, $subject, $message, $from): bool{
    $headers = "From: $from\r\n" .
               "Reply-To: $from\r\n" .
               "MIME-Version: 1.0\r\n" .
               "Content-Type: text/html; charset=UTF-8\r\n";
    return mail($to, $subject, $message, $headers);
}

?>