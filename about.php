<?php
$config = include __DIR__ . '/config.php';
include __DIR__ . '/header.php';
?>

<style>
  /* --- GLOBAL --- */
  .about {
    padding: 60px 20px;
    max-width: 1100px;
    margin: auto;
    font-family: "Poppins", sans-serif;
    line-height: 1.7;
  }
  .about h2 {
    text-align: center;
    color: #0b3d91;
    margin-bottom: 40px;
    font-size: 2.2em;
    position: relative;
  }
  .about h2::after {
    content: '';
    display: block;
    width: 60px;
    height: 3px;
    background: #0b3d91;
    margin: 10px auto 0;
    border-radius: 2px;
  }

  /* --- DEUX COLONNES --- */
  .two-col {
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
  }
  .two-col > div {
    flex: 1;
    min-width: 300px;
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(11,61,145,0.08);
  }
  .two-col h3 {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 16px;
    color: #0b3d91;
    font-size: 1.2em;
    border-left: 4px solid #0b3d91;
    padding-left: 10px;
  }
  .two-col p {
    color: #333;
    margin-top: 10px;
  }
  .two-col ul {
    margin-left: 20px;
    color: #444;
  }

  /* --- ÉQUIPE --- */
  .team-section {
    margin-top: 60px;
  }
  .team-section h3 {
    text-align: center;
    color: #0b3d91;
    margin-bottom: 32px;
    font-size: 1.7em;
  }
  .team-grid {
    display: flex;
    gap: 32px;
    flex-wrap: wrap;
    justify-content: center;
  }
  .member {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(11,61,145,0.08);
    max-width: 260px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .member:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 16px rgba(11,61,145,0.15);
  }
  .member img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 12px;
  }
  .member h4 {
    margin: 0 0 6px;
    font-weight: 700;
    color: #0b3d91;
  }
  .member p.role {
    color: #28a745;
    font-weight: 600;
    margin-bottom: 10px;
  }
  .member p.description {
    font-size: 0.95em;
    color: #555;
    margin-bottom: 14px;
  }

  /* --- FORMULAIRE CONTACT ÉQUIPE --- */
  .contact-member-form {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 16px;
  }
  .form-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
  .form-group label {
    font-size: 0.85em;
    font-weight: 600;
    color: #333;
  }
  .contact-member-form input,
  .contact-member-form textarea {
    border: 2px solid #e0e0e0;
    border-radius: 6px;
    padding: 10px 12px;
    font-size: 0.95em;
    resize: none;
    font-family: inherit;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }
  .contact-member-form input:focus,
  .contact-member-form textarea:focus {
    outline: none;
    border-color: #0b3d91;
    box-shadow: 0 0 0 3px rgba(11, 61, 145, 0.1);
  }
  .contact-member-form input::placeholder,
  .contact-member-form textarea::placeholder {
    color: #999;
  }
  .contact-member-form textarea {
    height: 80px;
    resize: vertical;
    min-height: 80px;
  }
  .contact-member-form button {
    background: #0b3d91;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 12px 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.95em;
  }
  .contact-member-form button:hover {
    background: #092d6e;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(11, 61, 145, 0.25);
  }
  .contact-member-form button:active {
    transform: translateY(0);
  }
  .form-message {
    padding: 10px 12px;
    border-radius: 6px;
    font-size: 0.9em;
    display: none;
    margin-bottom: 8px;
  }
  .form-message.success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    display: block;
  }
  .form-message.error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    display: block;
  }

  /* --- RESPONSIVE --- */
  /* Tablettes et appareils moyens (769px à 1024px) */
  @media (max-width: 1024px) {
    .about {
      padding: 40px 16px;
    }
    .about h2 {
      font-size: 1.8em;
      margin-bottom: 32px;
    }
    .two-col {
      gap: 32px;
    }
    .two-col > div {
      padding: 20px;
    }
    .team-grid {
      gap: 24px;
    }
    .member {
      max-width: 240px;
    }
  }

  /* Téléphones de grande taille et petit tablette (481px à 768px) */
  @media (max-width: 768px) {
    .about {
      padding: 30px 12px;
    }
    .about h2 {
      font-size: 1.5em;
      margin-bottom: 24px;
    }
    .about h2::after {
      width: 50px;
      height: 2px;
    }
    .two-col {
      flex-direction: column;
      gap: 20px;
    }
    .two-col > div {
      padding: 16px;
      border-radius: 10px;
    }
    .two-col h3 {
      font-size: 1.1em;
      gap: 6px;
    }
    .two-col p {
      font-size: 0.95em;
    }
    .two-col ul {
      margin-left: 16px;
      font-size: 0.95em;
    }

    .team-section {
      margin-top: 40px;
    }
    .team-section h3 {
      font-size: 1.4em;
      margin-bottom: 20px;
    }
    .team-grid {
      flex-direction: column;
      align-items: center;
      gap: 16px;
    }
    .member {
      width: 100%;
      max-width: 100%;
      padding: 16px;
      border-radius: 10px;
    }
    .member img {
      width: 80px;
      height: 80px;
      margin-bottom: 10px;
    }
    .member h4 {
      font-size: 1.1em;
    }
    .member p.role {
      font-size: 0.9em;
    }
    .member p.description {
      font-size: 0.9em;
    }

    .contact-member-form {
      gap: 10px;
      margin-top: 14px;
    }
    .form-group label {
      font-size: 0.8em;
    }
    .contact-member-form input,
    .contact-member-form textarea {
      padding: 8px 10px;
      font-size: 16px; /* Prévient le zoom sur iOS */
      border-radius: 4px;
    }
    .contact-member-form textarea {
      height: 70px;
      min-height: 70px;
    }
    .contact-member-form button {
      padding: 10px 14px;
      font-size: 0.9em;
      border-radius: 4px;
    }
    .form-message {
      padding: 8px 10px;
      font-size: 0.85em;
    }
  }

  /* Téléphones petits et moyens (320px à 480px) */
  @media (max-width: 480px) {
    .about {
      padding: 20px 10px;
    }
    .about h2 {
      font-size: 1.3em;
      margin-bottom: 20px;
    }
    .about h2::after {
      width: 40px;
    }
    .two-col {
      gap: 16px;
    }
    .two-col > div {
      padding: 14px;
      border-radius: 8px;
    }
    .two-col h3 {
      font-size: 1em;
      gap: 5px;
      margin-top: 12px;
    }
    .two-col h3 span {
      font-size: 1.1em;
    }
    .two-col p {
      font-size: 0.9em;
      line-height: 1.6;
    }
    .two-col ul {
      margin-left: 12px;
      font-size: 0.9em;
      padding-left: 0;
    }
    .two-col ul li {
      margin-bottom: 6px;
    }

    .team-section {
      margin-top: 30px;
    }
    .team-section h3 {
      font-size: 1.2em;
      margin-bottom: 16px;
    }
    .team-grid {
      gap: 12px;
    }
    .member {
      width: 100%;
      max-width: 100%;
      padding: 12px;
      border-radius: 8px;
      box-shadow: 0 1px 8px rgba(11,61,145,0.06);
    }
    .member:hover {
      transform: none;
      box-shadow: 0 2px 10px rgba(11,61,145,0.1);
    }
    .member img {
      width: 70px;
      height: 70px;
      margin-bottom: 8px;
    }
    .member h4 {
      font-size: 1em;
      margin-bottom: 4px;
    }
    .member p.role {
      font-size: 0.85em;
      margin-bottom: 8px;
    }
    .member p.description {
      font-size: 0.85em;
      margin-bottom: 10px;
    }

    .contact-member-form {
      gap: 8px;
      margin-top: 10px;
    }
    .form-group label {
      font-size: 0.75em;
    }
    .contact-member-form input,
    .contact-member-form textarea {
      padding: 7px 9px;
      font-size: 16px; /* Important: 16px pour éviter zoom iOS */
      border: 1px solid #ddd;
      border-radius: 3px;
    }
    .contact-member-form input:focus,
    .contact-member-form textarea:focus {
      border-color: #0b3d91;
      box-shadow: 0 0 0 2px rgba(11, 61, 145, 0.08);
    }
    .contact-member-form textarea {
      height: 60px;
      min-height: 60px;
      resize: vertical;
    }
    .contact-member-form button {
      padding: 9px 12px;
      font-size: 0.85em;
      border-radius: 3px;
      font-weight: 600;
    }
    .form-message {
      padding: 7px 9px;
      font-size: 0.8em;
    }
  }

  /* Ultra-petits écrans (moins de 320px) */
  @media (max-width: 320px) {
    .about {
      padding: 15px 8px;
    }
    .about h2 {
      font-size: 1.1em;
    }
    .two-col h3 {
      font-size: 0.95em;
    }
    .member img {
      width: 60px;
      height: 60px;
    }
    .contact-member-form input,
    .contact-member-form textarea {
      font-size: 16px;
    }
  }

  /* Optimisation des images pour tous les écrans */
  img {
    max-width: 100%;
    height: auto;
    display: block;
  }

  /* Prévention du zoom au focus sur iOS */
  input,
  textarea,
  select {
    font-size: 16px;
  }
</style>

<script>
// Amélioration des formulaires de contact
document.addEventListener('DOMContentLoaded', function() {
  const forms = document.querySelectorAll('.contact-member-form');
  
  forms.forEach(form => {
    form.addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const formId = this.id;
      const messageDiv = document.getElementById('msg-' + formId.replace('form-', ''));
      const submitBtn = this.querySelector('button[type="submit"]');
      const originalText = submitBtn.textContent;
      
      // Désactiver le bouton pendant l'envoi
      submitBtn.disabled = true;
      submitBtn.textContent = 'Envoi en cours...';
      messageDiv.className = '';
      
      try {
        const formData = new FormData(this);
        const response = await fetch(this.action, {
          method: 'POST',
          body: formData
        });
        
        const result = await response.text();
        
        if (response.ok && result.includes('success')) {
          messageDiv.className = 'form-message success';
          messageDiv.textContent = '✓ Message envoyé avec succès! Nous vous contacterons bientôt.';
          this.reset();
        } else {
          messageDiv.className = 'form-message error';
          messageDiv.textContent = '✗ Erreur lors de l\'envoi. Veuillez réessayer.';
        }
      } catch (error) {
        messageDiv.className = 'form-message error';
        messageDiv.textContent = '✗ Erreur de connexion. Veuillez vérifier votre connexion internet.';
      } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
        // Masquer le message après 5 secondes
        setTimeout(() => {
          if (messageDiv.classList.contains('success')) {
            messageDiv.className = '';
          }
        }, 5000);
      }
    });
  });
});
</script>

<section class="about">
  <h2><?= t('about'); ?></h2>

  <div class="two-col">
    <div>
      <h3><span>&#128736;</span> Présentation de l’entreprise</h3>
      <p><strong>CHEKUTAYA INVESTMENTS CONSTRUCTION SARL</strong> est une entreprise congolaise fondée par des passionnés du bâtiment et des travaux publics. Basée à Kinshasa, elle est née de la volonté de répondre efficacement aux besoins croissants en matière de construction, rénovation, et services techniques (plomberie, électricité, menuiserie, etc.).</p>
      <p>Notre équipe est composée de professionnels qualifiés, animés par le sens du travail bien fait et le respect des engagements.</p>

      <h3><span>&#128221;</span> Notre histoire</h3>
      <p>Depuis plus de 10 ans, <strong>CHEKUTAYA INVESTMENTS CONSTRUCTION</strong> accompagne particuliers et professionnels dans la réalisation de projets ambitieux à Kinshasa et ses environs. Notre engagement envers la qualité, l’innovation et la satisfaction client fait de nous un partenaire de confiance pour bâtir l’avenir.</p>
    </div>

    <div>
      <h3><span>&#127969;</span> Notre vision et mission</h3>
      <p><strong>Mission :</strong> Être une référence en RDC et en Afrique centrale dans le secteur du BTP, en offrant des solutions <strong>durables, modernes et adaptées aux exigences des clients</strong>.</p>
      <p><strong>Vision :</strong> Offrir des solutions de construction de qualité supérieure, en répondant aux attentes de nos clients avec professionnalisme, sécurité et innovation.</p>

      <h3><span>&#127919;</span> Nos objectifs</h3>
      <ul>
        <li>Devenir un acteur majeur du BTP en RDC et à l’international.</li>
        <li>Garantir des services de haute qualité à des tarifs compétitifs.</li>
        <li>Créer des emplois et former la nouvelle génération de professionnels du secteur.</li>
        <li>Promouvoir l’excellence, la transparence et la satisfaction client.</li>
      </ul>

      <h3><span>&#128221;</span> Nos valeurs</h3>
      <ul>
        <li><strong>Professionnalisme :</strong> Respect des délais, des normes et de la qualité.</li>
        <li><strong>Intégrité :</strong> Transparence dans nos relations et nos services.</li>
        <li><strong>Innovation :</strong> Adoption des nouvelles technologies et méthodes modernes.</li>
        <li><strong>Engagement :</strong> Priorité à la satisfaction du client.</li>
        <li><strong>Sécurité :</strong> Conditions de travail sûres pour nos équipes et nos partenaires.</li>
      </ul>
    </div>
  </div>

  <div class="team-section">
    <h3><span style="font-size:1.3em;color:#ff8c00;">&#128101;</span> Notre équipe</h3>

    <div class="team-grid">
      <div class="member">
        <img src="assets/images/Equipe.jpg" alt="Jimmy TSHIBASU">
        <h4>JIMMY TSHIBASU</h4>
        <p class="role">Chef de chantier</p>
        <p class="description">Expert en gestion de projets et supervision de chantiers complexes, Jimmy veille à la qualité et à la sécurité sur chaque réalisation.</p>
        <form class="contact-member-form" method="post" action="send_message.php" id="form-jimmy">
          <div class="form-message" id="msg-jimmy"></div>
          <input type="hidden" name="destinataire" value="Jimmy TSHIBASU">
          <div class="form-group">
            <label for="nom-jimmy">Votre nom *</label>
            <input type="text" id="nom-jimmy" name="nom" placeholder="Ex: Jean Dupont" required aria-label="Nom">
          </div>
          <div class="form-group">
            <label for="email-jimmy">Votre email *</label>
            <input type="email" id="email-jimmy" name="email" placeholder="Ex: example@email.com" required aria-label="Email">
          </div>
          <div class="form-group">
            <label for="msg-field-jimmy">Votre message *</label>
            <textarea id="msg-field-jimmy" name="message" placeholder="Décrivez votre projet ou votre demande..." required aria-label="Message"></textarea>
          </div>
          <button type="submit" aria-label="Envoyer le message à Jimmy TSHIBASU">Envoyer à Jimmy</button>
        </form>
      </div>

      <div class="member">
        <img src="assets/images/team2-placeholder.jpg" alt="Meta Christenvie">
        <h4>META CHRISTENVIE</h4>
        <p class="role">Responsable</p>
        <p class="description">Spécialiste en conception de plans innovants et en design durable, Meta apporte créativité et rigueur à chaque projet.</p>
        <form class="contact-member-form" method="post" action="send_message.php" id="form-meta">
          <div class="form-message" id="msg-meta"></div>
          <input type="hidden" name="destinataire" value="Meta CHRISTENVIE">
          <div class="form-group">
            <label for="nom-meta">Votre nom *</label>
            <input type="text" id="nom-meta" name="nom" placeholder="Ex: Jean Dupont" required aria-label="Nom">
          </div>
          <div class="form-group">
            <label for="email-meta">Votre email *</label>
            <input type="email" id="email-meta" name="email" placeholder="Ex: example@email.com" required aria-label="Email">
          </div>
          <div class="form-group">
            <label for="msg-field-meta">Votre message *</label>
            <textarea id="msg-field-meta" name="message" placeholder="Décrivez votre projet ou votre demande..." required aria-label="Message"></textarea>
          </div>
          <button type="submit" style="background:#28a745;" aria-label="Envoyer le message à Meta CHRISTENVIE">Envoyer à Meta</button>
        </form>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
