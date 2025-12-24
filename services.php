<?php
$config = include __DIR__ . '/config.php';
include __DIR__ . '/header.php';
?>

<section class="services">
  <h2><?php echo t('services'); ?></h2>
  <p class="services-intro">
    Découvrez l’ensemble de nos prestations — du gros œuvre aux finitions — pour vos projets de construction, rénovation et aménagement.
  </p>

  <div class="service-list">
    <article class="service-item fade-up">
      <div class="service-icon">
        <img src="assets/images/ConnstructionGeneral.webp" alt="Construction et rénovation">
      </div>
      <h3>Construction &amp; Rénovation</h3>
      <p>Construction de bâtiments neufs et rénovation complète ou partielle, avec des matériaux de qualité et une expertise reconnue.</p>
    </article>

    <article class="service-item fade-up">
      <div class="service-icon">
        <img src="assets/images/ServicePlom.webp" alt="Plomberie et électricité">
      </div>
      <h3>Plomberie &amp; Électricité</h3>
      <p>Installation, maintenance et mise aux normes des réseaux d’électricité et de plomberie pour vos bâtiments.</p>
    </article>

    <article class="service-item fade-up">
      <div class="service-icon">
        <img src="assets/images/Camera.webp" alt="Sécurité et caméras">
      </div>
      <h3>Sécurité &amp; Caméras</h3>
      <p>Installation de systèmes de surveillance modernes pour la sécurité de vos espaces résidentiels et commerciaux.</p>
    </article>

    <article class="service-item fade-up">
      <div class="service-icon">
        <img src="assets/images/DecorInterrieur1.jpg" alt="Peinture et décoration">
      </div>
      <h3>Peinture &amp; Décoration</h3>
      <p>Finitions haut de gamme, aménagements intérieurs, peinture et charpenterie pour sublimer vos espaces.</p>
    </article>

    <article class="service-item fade-up">
      <div class="service-icon">
        <img src="assets/images/Carellage.webp" alt="Carrelage">
      </div>
      <h3>Carrelage</h3>
      <p>Pose de carrelage, faïence et revêtements décoratifs pour sols et murs, intérieurs et extérieurs.</p>
    </article>
  </div>

  <!-- --- Section Devis --- -->
  <div class="service-contact fade-up">
    <h3>Demander un devis ou des informations</h3>
    <p>Besoin d’un devis détaillé ou d’une consultation ? Contactez-nous en quelques clics.</p>

    <form action="devis.php" method="get">
      <button type="submit" class="btn-devis">Aller au formulaire de devis</button>
    </form>
  </div>
</section>

<style>
/* --- STYLE GÉNÉRAL --- */
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: #f4f7fb;
  color: #333;
  margin: 0;
  padding: 0;
}

/* --- SECTION SERVICES --- */
.services {
  max-width: 1200px;
  margin: 0 auto;
  padding: 80px 20px;
  text-align: center;
}

.services h2 {
  font-size: 2.4rem;
  color: #0b3d91;
  margin-bottom: 10px;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.services-intro {
  font-size: 1.05rem;
  color: #555;
  max-width: 700px;
  margin: 0 auto 50px;
  line-height: 1.6;
}

/* --- CARTES DE SERVICES --- */
.service-list {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;
  justify-content: center;
}

.service-item {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.06);
  padding: 2rem 1.5rem;
  width: 310px;
  text-align: center;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.service-item:hover {
  transform: translateY(-8px);
  box-shadow: 0 8px 24px rgba(11,61,145,0.15);
}

/* --- Icône --- */
.service-icon {
  width: 90px;
  height: 90px;
  margin: 0 auto 1rem;
  border-radius: 50%;
  background: #e6edfa;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: 0.3s ease;
}

.service-item:hover .service-icon {
  background: #0b3d91;
  transform: rotate(6deg);
}

.service-icon img {
  width: 55px;
  height: 55px;
  object-fit: contain;
  filter: brightness(0.9);
  transition: 0.3s ease;
}

.service-item:hover .service-icon img {
  filter: brightness(3);
}

/* --- Titres & Textes --- */
.service-item h3 {
  color: #0b3d91;
  font-size: 1.25rem;
  margin: 0.8rem 0;
}

.service-item p {
  font-size: 0.98rem;
  color: #555;
  line-height: 1.5;
}

/* --- SECTION DEVIS --- */
.service-contact {
  margin-top: 70px;
  background: linear-gradient(135deg, #0b3d91, #1a5ee3);
  color: #fff;
  padding: 2.5rem;
  border-radius: 14px;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
  text-align: center;
  box-shadow: 0 6px 18px rgba(11,61,145,0.25);
}

.service-contact h3 {
  font-size: 1.6rem;
  margin-bottom: 12px;
}

.service-contact p {
  font-size: 1rem;
  margin-bottom: 20px;
  color: #f0f3ff;
}

/* --- BOUTON --- */
.btn-devis {
  background: #fff;
  color: #0b3d91;
  border: none;
  padding: 0.9rem 2rem;
  border-radius: 30px;
  font-size: 1.05rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-devis:hover {
  background: #f4f7fb;
  transform: translateY(-2px);
}

/* --- ANIMATIONS --- */
.fade-up {
  opacity: 0;
  transform: translateY(40px);
  transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}

.fade-up.visible {
  opacity: 1;
  transform: translateY(0);
}

/* --- RESPONSIVE --- */
@media (max-width: 900px) {
  .service-list {
    flex-direction: column;
    align-items: center;
  }
  .service-item {
    width: 90%;
  }
  .services h2 {
    font-size: 2rem;
  }
}
</style>

<!-- --- SCRIPT D'ANIMATION --- -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const elements = document.querySelectorAll('.fade-up');

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.2 });

    elements.forEach(el => observer.observe(el));
  });
</script>

<?php include __DIR__ . '/footer.php'; ?>
