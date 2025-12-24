<?php
$config = include __DIR__ . '/config.php';
include __DIR__ . '/header.php';
?>

<style>
/* --- SECTION RÉALISATIONS --- */
section.realisations {
  padding: 60px 8%;
  background-color: #f8f9fb;
  text-align: center;
}

.realisations h2 {
  font-size: 2.2rem;
  color: #0b3d91;
  margin-bottom: 10px;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.realisations .section-intro {
  color: #555;
  max-width: 700px;
  margin: 0 auto 40px;
  font-size: 1rem;
  line-height: 1.6;
}

/* --- FILTRES --- */
.gallery-filter {
  margin-bottom: 40px;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 12px;
}

.gallery-filter button {
  background-color: #0b3d91;
  color: #fff;
  border: none;
  padding: 10px 24px;
  border-radius: 30px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}

.gallery-filter button:hover,
.gallery-filter button.active {
  background-color: #1a5ee3;
  transform: translateY(-2px);
}

/* --- GALERIE --- */
.gallery-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 20px;
}

.gallery-item {
  position: relative;
  overflow: hidden;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.08);
  background: #fff;
  transition: all 0.4s ease;
  opacity: 1;
}

.gallery-item.hide {
  opacity: 0;
  transform: scale(0.9);
  pointer-events: none;
}

.gallery-item img {
  width: 100%;
  height: 220px;
  object-fit: cover;
  border-radius: 12px 12px 0 0;
  transition: transform 0.4s ease;
  cursor: pointer;
}

.gallery-item:hover img {
  transform: scale(1.05);
}

.gallery-item p {
  padding: 12px;
  margin: 0;
  color: #333;
  font-weight: 500;
  background-color: #fff;
  border-top: 1px solid #eee;
  border-radius: 0 0 12px 12px;
}

/* --- LIGHTBOX --- */
.lightbox {
  display: none;
  position: fixed;
  z-index: 9999;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.85);
  backdrop-filter: blur(4px);
  align-items: center;
  justify-content: center;
  animation: fadeIn 0.4s ease;
}

@keyframes fadeIn {
  from { opacity: 0; } to { opacity: 1; }
}

.lightbox img {
  max-width: 90%;
  max-height: 80vh;
  border-radius: 12px;
  box-shadow: 0 0 25px rgba(255,255,255,0.3);
  animation: zoomIn 0.4s ease;
}

@keyframes zoomIn {
  from { transform: scale(0.8); opacity: 0; } 
  to { transform: scale(1); opacity: 1; }
}

.lightbox .close-btn {
  position: absolute;
  top: 30px;
  right: 40px;
  font-size: 2.2rem;
  color: #fff;
  cursor: pointer;
  transition: 0.3s;
}

.lightbox .close-btn:hover {
  color: #ff5555;
}
</style>

<section class="realisations full">
  <h2><?php echo t('realisations'); ?></h2>
  <p class="section-intro">
    Découvrez quelques-unes de nos réalisations — constructions, rénovations, aménagements et décorations intérieures.
  </p>

  <div class="gallery-filter">
    <button class="active" data-filter="all">Tous</button>
    <button data-filter="construction">Constructions</button>
    <button data-filter="interieur">Décor Intérieur</button>
    <button data-filter="plomberie">Plomberie</button>
    <button data-filter="chantier">Chantiers</button>
  </div>

  <div class="gallery-grid large">
    <div class="gallery-item" data-category="construction">
      <img src="assets/images/Construction1.jpg" alt="Construction">
      <p>Construction </p>
    </div>

    <div class="gallery-item" data-category="interieur">
      <img src="assets/images/DecorInterrieur2.jpg" alt="Décor Intérieur">
      <p>Décor Intérieur </p>
    </div>

    <div class="gallery-item" data-category="chantier">
      <img src="assets/images/imageChantier1.jpg" alt="Chantier">
      <p>Chantier </p>
    </div>

    <div class="gallery-item" data-category="plomberie">
      <img src="assets/images/Plomberie33.jpg" alt="Plomberie">
      <p>Plomberie </p>
    </div>

    <div class="gallery-item" data-category="construction">
      <img src="assets/images/Construction2.jpg" alt="Construction">
      <p>Construction </p>
    </div>

    <div class="gallery-item" data-category="interieur">
      <img src="assets/images/DecorInterrieur1.jpg" alt="Décor Intérieur">
      <p>Décor Intérieur </p>
    </div>

    <div class="gallery-item" data-category="interieur">
      <img src="assets/images/DecorInterrieur3.jpg" alt="Décor Intérieur">
      <p>Décor Intérieur </p>
    </div>

    <div class="gallery-item" data-category="chantier">
      <img src="assets/images/imageChantier2.jpg" alt="Chantier">
      <p>Chantier </p>
    </div>

    <div class="gallery-item" data-category="plomberie">
      <img src="assets/images/plomblerie2.jpg" alt="Plomberie">
      <p>Plomberie </p>
    </div>

    <div class="gallery-item" data-category="interieur">
      <img src="assets/images/DecorInterrieur6.jpg" alt="Décor Intérieur">
      <p>Décor Intérieur </p>
    </div>
  </div>
</section>

<!-- --- LIGHTBOX --- -->
<div class="lightbox" id="lightbox">
  <span class="close-btn" id="lightboxClose">&times;</span>
  <img src="" alt="Image agrandie" id="lightboxImg">
</div>

<script>
// --- Script de filtrage interactif ---
document.addEventListener("DOMContentLoaded", () => {
  const filterButtons = document.querySelectorAll(".gallery-filter button");
  const galleryItems = document.querySelectorAll(".gallery-item");
  const lightbox = document.getElementById("lightbox");
  const lightboxImg = document.getElementById("lightboxImg");
  const closeBtn = document.getElementById("lightboxClose");

  // --- FILTRAGE ---
  filterButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      filterButtons.forEach(b => b.classList.remove("active"));
      btn.classList.add("active");
      const filterValue = btn.getAttribute("data-filter");

      galleryItems.forEach(item => {
        const category = item.getAttribute("data-category");
        if (filterValue === "all" || filterValue === category) {
          item.classList.remove("hide");
        } else {
          item.classList.add("hide");
        }
      });
    });
  });

  // --- LIGHTBOX ---
  document.querySelectorAll(".gallery-item img").forEach(img => {
    img.addEventListener("click", () => {
      lightboxImg.src = img.src;
      lightbox.style.display = "flex";
    });
  });

  closeBtn.addEventListener("click", () => {
    lightbox.style.display = "none";
  });

  lightbox.addEventListener("click", e => {
    if (e.target === lightbox) lightbox.style.display = "none";
  });
});
</script>

<?php include __DIR__ . '/footer.php'; ?>
