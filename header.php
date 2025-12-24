<?php
if(!isset($config) || !is_array($config)) {
    $config = include_once __DIR__ . '/config.php';
}
include_once __DIR__ . '/functions.php';
$site = $config['site_name'];
?>
<!doctype html>
<html lang="<?php echo lang(); ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes, viewport-fit=cover">
  <meta name="theme-color" content="#0b3d91">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <title><?php echo htmlspecialchars($site); ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container branding">
    <img src="assets/images/CIC-LOGO-VERSION-FINAL.jpg" alt="Logo EJC Construction" style="height: 100px;px;vertical-align:middle;margin: right 100px;px;">
    <h1><?php echo htmlspecialchars($config['site_name']); ?></h1>
    <p class="slogan"><?php echo htmlspecialchars($config['slogan']); ?></p>
  </div>
  <nav class="main-nav">
    <a href="<?php echo url_with_lang('index.php'); ?>"><?php echo t('home'); ?></a>
    <a href="<?php echo url_with_lang('about.php'); ?>"><?php echo t('about'); ?></a>
    <a href="<?php echo url_with_lang('services.php'); ?>"><?php echo t('services'); ?></a>
    <a href="<?php echo url_with_lang('realizations.php'); ?>"><?php echo t('realisations'); ?></a>
    <a href="<?php echo url_with_lang('devis.php'); ?>">Demande de devis</a>
    <a href="<?php echo url_with_lang('contact.php'); ?>"><?php echo t('contact'); ?></a>
  </nav>
  <div class="lang-switch">
    <a href="?lang=fr">FR</a> | <a href="?lang=en">EN</a>
  </div>
</header>
