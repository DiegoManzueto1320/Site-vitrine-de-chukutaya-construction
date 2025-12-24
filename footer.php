<?php
$config = include __DIR__ . '/config.php';
$social = isset($config['social']) ? $config['social'] : [];
?>

<footer class="site-footer">
  <div class="container footer-content">
    <div class="footer-info">
      <h3><?php echo htmlspecialchars($config['site_name']); ?></h3>
      <p><?php echo htmlspecialchars($config['slogan']); ?></p>
      <p><strong>Adresse :</strong> Ville de Kinshasa, Avenue Cocotier, n°07, Commune de la GOMBE</p>
      <p><strong>Email :</strong> chekinvest.cd@gmail.com</p>
      <p><strong>Téléphone :</strong> +243819536264, +243822987259</p>
    </div>

    <div class="footer-social">
      <h4>Suivez-nous</h4>
      <div class="social-follow">
        <?php if (!empty($social['facebook'])): ?>
          <a href="<?php echo htmlspecialchars($social['facebook']); ?>"
             target="_blank" rel="noopener noreferrer" aria-label="Facebook">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M13 3h4v4h-4v3h3v4h-3v7h-4v-7H8v-4h2V7a4 4 0 0 1 4-4z"/>
            </svg>
            <span>Facebook</span>
          </a>
        <?php endif; ?>

        <?php if (!empty($social['instagram'])): ?>
          <a href="<?php echo htmlspecialchars($social['instagram']); ?>"
             target="_blank" rel="noopener noreferrer" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="2" y="2" width="20" height="20" rx="5" stroke="currentColor" stroke-width="1.3"/>
              <path d="M7 12a5 5 0 1 0 10 0 5 5 0 0 0-10 0z" stroke="currentColor" stroke-width="1.3"/>
              <circle cx="17.5" cy="6.5" r="0.9" fill="currentColor"/>
            </svg>
            <span>Instagram</span>
          </a>
        <?php endif; ?>

        <?php if (!empty($social['tiktok'])): ?>
          <a href="<?php echo htmlspecialchars($social['tiktok']); ?>"
             target="_blank" rel="noopener noreferrer" aria-label="TikTok">
            <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path d="M16 6.5v6.2a3.5 3.5 0 1 1-3.5-3.5V5h3.5z"/>
            </svg>
            <span>TikTok</span>
          </a>
        <?php endif; ?>

        <?php if (!empty($social['linkedin'])): ?>
          <a href="<?php echo htmlspecialchars($social['linkedin']); ?>"
             target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M4.98 3.5C4.98 4.88 3.9 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1 4.98 2.12 4.98 3.5zM0 8h5v16H0V8zm7.5 0H12v2.2c.6-1 2-2.4 4.7-2.4C20.6 7.8 23 10.2 23 15v9h-5v-8c0-1.9-.7-3.2-2.4-3.2-1.3 0-2.1.9-2.4 1.8-.1.3-.2.8-.2 1.3v8h-5V8z"/>
            </svg>
            <span>LinkedIn</span>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    &copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($config['site_name']); ?>. Tous droits réservés.
  </div>
</footer>

<style>
/* --- FOOTER --- */
.site-footer {
  background: linear-gradient(135deg, #0b3d91, #062a64);
  color: #fff;
  padding: 40px 0 20px;
  margin-top: 60px;
  font-family: 'Segoe UI', sans-serif;
  box-shadow: 0 -3px 10px rgba(0,0,0,0.15);
}
.site-footer .container {
  max-width: 1100px;
  margin: auto;
  padding: 0 20px;
}
.footer-content {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: flex-start;
  gap: 30px;
}
.footer-info h3 {
  margin-bottom: 6px;
}
.footer-info p {
  margin: 4px 0;
  font-size: 15px;
  opacity: 0.9;
}
.footer-social h4 {
  margin-bottom: 10px;
  font-size: 1.1rem;
  color: #f1f1f1;
}
.social-follow {
  display:flex;
  flex-wrap:wrap;
  gap:14px;
}
.social-follow a {
  display:inline-flex;
  align-items:center;
  gap:8px;
  padding:8px 12px;
  border-radius:8px;
  background:rgba(255,255,255,0.1);
  color:#fff;
  font-weight:600;
  text-decoration:none;
  transition:all .25s ease;
}
.social-follow a:hover {
  background:#fff;
  color:#0b3d91;
  transform:translateY(-3px);
}
.social-follow svg {
  width:20px;
  height:20px;
}
.footer-bottom {
  text-align:center;
  border-top:1px solid rgba(255,255,255,0.2);
  margin-top:25px;
  padding-top:12px;
  font-size:0.9rem;
  opacity:0.8;
}
@media (max-width:768px) {
  .footer-content {
    flex-direction:column;
    align-items:center;
    text-align:center;
  }
}
</style>
