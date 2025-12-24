<?php
$config = include_once __DIR__ . '/config.php';
include __DIR__ . '/header.php';
?>

<style>
  /* === GLOBAL === */
  :root {
    --primary-color: #0b3d91;
    --secondary-color: #092d6e;
    --accent-color: #28a745;
    --text-color: #333;
    --bg-light: #f5f8fc;
    --shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    --radius: 12px;
    --transition: all 0.4s ease;
  }

  body {
    font-family: 'Poppins', Arial, sans-serif;
    color: var(--text-color);
    line-height: 1.6;
  }

  h2 {
    font-weight: 700;
    text-align: center;
    margin-bottom: 36px;
  }

  /* === ANIMATIONS === */
  [data-reveal] {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.8s ease, transform 0.8s ease;
  }

  [data-reveal].active {
    opacity: 1;
    transform: translateY(0);
  }

  /* === HERO === */
  .hero {
    background: linear-gradient(rgba(11, 61, 145, 0.7), rgba(11, 61, 145, 0.7)),
                url('assets/images/chantier.jpg') center/cover no-repeat;
    color: #fff;
    text-align: center;
    padding: 100px 20px;
    position: relative;
  }

  .hero h1 {
    font-size: 3em;
    font-weight: 800;
    margin-bottom: 16px;
    text-shadow: 0 3px 8px rgba(0, 0, 0, 0.4);
  }

  .hero p {
    font-size: 1.2em;
    margin-bottom: 30px;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
  }

  .btn-primary {
    background: var(--primary-color);
    color: #fff;
    padding: 14px 36px;
    border-radius: var(--radius);
    font-weight: 600;
    font-size: 1.05em;
    text-decoration: none;
    transition: var(--transition);
    display: inline-block;
  }

  .btn-primary:hover {
    background: var(--secondary-color);
    transform: translateY(-2px);
  }

  /* === SERVICES === */
  .services-preview {
    background: #fff;
    padding: 80px 20px;
  }

  .services-preview h2 {
    color: var(--primary-color);
    font-size: 2.2em;
  }

  .services-grid {
    display: flex;
    gap: 36px;
    justify-content: center;
    flex-wrap: wrap;
  }

  .service-card {
    background: #fff;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 24px;
    max-width: 280px;
    text-align: center;
    transition: var(--transition);
  }

  .service-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 24px rgba(11, 61, 145, 0.15);
  }

  .service-card img {
    width: 100%;
    border-radius: 8px;
    margin: 16px 0;
    object-fit: cover;
  }

  .service-card h3 {
    color: var(--primary-color);
    margin-bottom: 10px;
    font-weight: 600;
  }

  .service-card p {
    font-size: 0.95em;
    color: #555;
  }

  /* === REALISATIONS === */
  .realisations-preview {
    background: var(--bg-light);
    padding: 80px 20px;
  }

  .realisations-preview h2 {
    color: var(--primary-color);
    font-size: 2.2em;
  }

  .gallery-grid {
    display: flex;
    gap: 24px;
    justify-content: center;
    flex-wrap: wrap;
  }

  .gallery-grid img {
    width: 240px;
    height: 160px;
    border-radius: 8px;
    object-fit: cover;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: var(--shadow);
  }

  .gallery-grid img:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 18px rgba(11, 61, 145, 0.25);
  }

  .see-more {
    text-align: center;
    margin-top: 36px;
  }

  /* === RESPONSIVE === */
  @media (max-width: 768px) {
    .hero h1 { font-size: 2.2em; }
    .hero p { font-size: 1.05em; }
    .service-card { max-width: 90%; }
    .gallery-grid img { width: 90%; height: auto; }
  }
</style>

<!-- HERO -->
<section class="hero" data-reveal>
  <div class="hero-inner">
    <h1><?= htmlspecialchars($config['site_name']) ?></h1>
    <p><?= htmlspecialchars($config['slogan']) ?></p>
    <a class="btn-primary" href="<?= url_with_lang('devis.php') ?>">
      <?= t('request_quote') ?>
    </a>
  </div>
</section>

<!-- SERVICES -->
<section class="services-preview" data-reveal>
  <h2><?= t('services') ?></h2>
  <div class="services-grid">

    <div class="service-card" data-reveal>
      <span style="font-size:2em;color:var(--primary-color);">&#128736;</span>
      <img src="assets/images/ConnstructionGeneral.webp" alt="Construction générale - bâtiments résidentiels et commerciaux">
      <h3>Construction générale</h3>
      <p>Conception et réalisation de bâtiments résidentiels, commerciaux et industriels avec excellence et durabilité.</p>
    </div>

    <div class="service-card" data-reveal>
      <span style="font-size:2em;color:var(--accent-color);">&#128221;</span>
      <img src="assets/images/imageChantier2.jpg" alt="Rénovation & réhabilitation de bâtiments">
      <h3>Rénovation & réhabilitation</h3>
      <p>Modernisation et transformation de bâtiments existants pour valoriser votre patrimoine.</p>
    </div>

    <div class="service-card" data-reveal>
      <span style="font-size:2em;color:#ff8c00;">&#127963;</span>
      <img src="assets/images/DecorInterrieur1.jpg" alt="Décoration intérieure et aménagements">
      <h3>Décoration intérieure</h3>
      <p>Travaux de peinture, charpenterie et aménagements pour sublimer vos espaces.</p>
    </div>

    <div class="service-card" data-reveal>
      <span style="font-size:2em;color:#007bff;">&#128247;</span>
      <img src="assets/images/Camera.webp" alt="Installation de caméras de surveillance">
      <h3>Installation de caméras</h3>
      <p>Solutions de sécurité et surveillance fiables pour vos chantiers et propriétés.</p>
    </div>

    <div class="service-card" data-reveal>
      <span style="font-size:2em;color:#a67c52;">&#128719;</span>
      <img src="assets/images/Carellage.webp" alt="Pose de carrelage professionnel">
      <h3>Pose de carrelage</h3>
      <p>Pose murale et au sol, finitions précises et durabilité assurée pour vos espaces intérieurs et extérieurs.</p>
    </div>

  </div>
</section>

<!-- RÉALISATIONS -->
<section class="realisations-preview" data-reveal>
  <h2><?= t('realisations') ?></h2>
  <div class="gallery-grid">
    <img src="assets/images/DecorInterrieur3.jpg" alt="Réalisation 1 - Chantier terminé" data-reveal>
    <img src="assets/images/DecorInterrieur8.jpg" alt="Réalisation 2 - Travaux en cours" data-reveal>
    <img src="assets/images/Plombieirie.jpg" alt="Réalisation 3 - Projet de construction" data-reveal>
  </div>
  <div class="see-more" data-reveal>
    <a class="btn-primary" href="<?= url_with_lang('realizations.php') ?>">
      <?= t('see_more') ?>
    </a>
  </div>
</section>

<script>
  // Animation d’apparition douce au défilement
  const revealElements = document.querySelectorAll('[data-reveal]');
  const revealOnScroll = () => {
    const triggerBottom = window.innerHeight * 0.85;
    revealElements.forEach(el => {
      const boxTop = el.getBoundingClientRect().top;
      if (boxTop < triggerBottom) {
        el.classList.add('active');
      }
    });
  };
  window.addEventListener('scroll', revealOnScroll);
  window.addEventListener('load', revealOnScroll);
</script>
<?php include __DIR__ . '/footer.php'; ?>
