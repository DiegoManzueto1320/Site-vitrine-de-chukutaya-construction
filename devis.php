<?php include('header.php'); ?>

<style>
    .quote-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(11,61,145,0.08), 0 1.5px 6px rgba(0,0,0,0.04);
        padding: 38px 28px;
        max-width: 600px;
        margin: 40px auto;
        transition: box-shadow 0.2s;
    }
    .quote-card:hover {
        box-shadow: 0 8px 32px rgba(11,61,145,0.13), 0 2px 8px rgba(0,0,0,0.07);
    }
    .form-group {
        position: relative;
        margin-bottom: 28px;
    }
    .form-control {
        border-radius: 8px;
        border: 1px solid #dbe6f7;
        padding: 14px 12px;
        font-size: 1.07rem;
        background: #f8fbff;
        transition: border-color 0.2s;
    }
    .form-control:focus {
        border-color: #0b3d91;
        background: #fff;
        outline: none;
        box-shadow: 0 0 0 2px #e0e6f1;
    }
    .form-group label {
        font-weight: 500;
        color: #0b3d91;
        margin-bottom: 7px;
        display: block;
        font-size: 1.04rem;
    }
    .form-check-label {
        font-size: 0.98rem;
        color: #444;
    }
    .btn-primary {
        background: linear-gradient(90deg,#0b3d91 60%,#3a7bd5 100%);
        border: none;
        border-radius: 8px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(11,61,145,0.09);
        transition: background 0.2s;
    }
    .btn-primary:hover {
        background: linear-gradient(90deg,#3a7bd5 60%,#0b3d91 100%);
    }
    .input-icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #3a7bd5;
        font-size: 1.15em;
        pointer-events: none;
    }
    .form-control.with-icon {
        padding-left: 2.2em;
    }
    .form-text {
        font-size: 0.93em;
        color: #888;
        margin-top: 3px;
    }
    @media (max-width: 700px) {
        .quote-card { padding: 18px 7px; }
    }
</style>

<main>
    <div class="quote-card">
        <h2 class="text-center mb-2" style="display:flex;align-items:center;justify-content:center;gap:10px;">
            <span style="font-size:2.3rem;color:#0b3d91;">&#128221;</span>
            <span>Demande de devis</span>
        </h2>
        <p class="text-center" style="color:#555;font-size:1.09rem;margin-bottom:18px;">
            Remplissez le formulaire pour recevoir votre devis personnalisé.<br>
            <span style="font-size:0.97em;color:#0b3d91;">Réponse sous 48h ouvrées.</span>
        </p>
        <hr style="margin:18px 0;border:none;border-top:1px solid #e0e6f1;">

        <form action="send_quote.php" method="POST" enctype="multipart/form-data" autocomplete="on">
            <div class="form-group">
                <span class="input-icon">&#128100;</span>
                <label for="name">Nom complet <span style="color:red">*</span></label>
                <input type="text" id="name" name="name" class="form-control with-icon" required placeholder="Votre nom complet">
            </div>

            <div class="form-group">
                <span class="input-icon">&#9993;</span>
                <label for="email">Email <span style="color:red">*</span></label>
                <input type="email" id="email" name="email" class="form-control with-icon" required placeholder="exemple@domaine.com">
            </div>

            <div class="form-group">
                <span class="input-icon">&#128274;</span>
                <label for="confirm_email">Confirmez l’email <span style="color:red">*</span></label>
                <input type="email" id="confirm_email" name="confirm_email" class="form-control with-icon" required placeholder="Confirmez votre email">
            </div>

            <div class="form-group">
                <span class="input-icon">&#128222;</span>
                <label for="phone">Téléphone <span style="color:red">*</span></label>
                <input type="tel" id="phone" name="phone" class="form-control with-icon" required pattern="^\+?\d{9,15}$" placeholder="+243XXXXXXXXX">
                <small class="form-text">Format : +243XXXXXXXXX</small>
            </div>

            <div class="form-group">
                <span class="input-icon">&#127968;</span>
                <label for="address">Adresse du chantier <span style="color:red">*</span></label>
                <input type="text" id="address" name="address" class="form-control with-icon" required placeholder="Adresse complète du chantier">
            </div>

            <div class="form-group mb-3">
                <label for="project_type">Type de projet <span style="color:red">*</span></label>
                <select id="project_type" name="project_type" class="form-control" required>
                    <option value="">-- Sélectionnez --</option>
                    <option value="Construction neuve">Construction neuve</option>
                    <option value="Rénovation">Rénovation</option>
                    <option value="Aménagement">Aménagement</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="surface">Surface approximative (m²)</label>
                <input type="number" id="surface" name="surface" class="form-control" min="1" placeholder="Ex: 120">
            </div>

            <div class="form-group mb-3">
                <label for="deadline">Délai souhaité</label>
                <input type="text" id="deadline" name="deadline" class="form-control" placeholder="Ex: 3 mois, 6 mois">
            </div>

            <div class="form-group mb-3">
                <label for="budget">Budget estimé (USD)</label>
                <input type="number" id="budget" name="budget" class="form-control" min="0" step="0.01" placeholder="Ex: 5000">
            </div>

            <div class="form-group mb-3">
                <label for="details">Description détaillée du projet <span style="color:red">*</span></label>
                <textarea id="details" name="details" class="form-control" rows="5" required placeholder="Décrivez votre projet en détail"></textarea>
            </div>

            <div class="form-group mb-3">
                <label for="attachment">Fichiers (plans, images, PDF)</label>
                <input type="file" id="attachment" name="attachment[]" class="form-control" accept=".jpg,.jpeg,.png,.pdf" multiple>
                <small class="form-text text-muted">Vous pouvez joindre plusieurs fichiers.</small>
            </div>

            <div class="form-group mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="rgpd" name="rgpd" required>
                <label class="form-check-label" for="rgpd">
                    J'accepte que mes données soient utilisées pour me recontacter. <a href="#">En savoir plus</a>
                </label>
            </div>

            <!-- reCAPTCHA Google -->
            <div id="recaptcha-container" class="mb-4">
                <div class="g-recaptcha" data-sitekey="6LeifvgrAAAAAJce8o9rIe83QrGon_B89BWWEVqy" data-callback="enableSubmitBtn" data-expired-callback="expiredRecaptcha"></div>
                <div id="recaptcha-error" class="text-danger mt-2" style="display: none;">
                    <small>⚠️ Veuillez cocher la case "Je ne suis pas un robot"</small>
                </div>
            </div>

            <div class="text-center" style="margin-top:18px;">
                <button type="submit" id="submitBtn" class="btn btn-primary px-4 py-2" style="font-size:1.15rem;" disabled>
                    &#128233; Envoyer la demande
                </button>
            </div>
        </form>
    </div>
</main>

<!-- Script Google reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>
  // Variable pour suivre l'état du reCAPTCHA
  let recaptchaVerified = false;

  // Fonction appelée quand reCAPTCHA est validé
  function enableSubmitBtn(response) {
    if (response && response.length > 0) {
      document.getElementById('submitBtn').disabled = false;
      document.getElementById('recaptcha-error').style.display = 'none';
      recaptchaVerified = true;
    }
  }

  // Fonction appelée quand reCAPTCHA expire
  function expiredRecaptcha() {
    document.getElementById('submitBtn').disabled = true;
    document.getElementById('recaptcha-error').style.display = 'block';
    document.getElementById('recaptcha-error').innerHTML = '<small>⏰ Le reCAPTCHA a expiré. Veuillez le valider à nouveau.</small>';
    recaptchaVerified = false;
  }

  // Attendre que le DOM soit chargé
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    // Validation du formulaire
    form.addEventListener('submit', function(e) {
      // Vérification des emails
      const email = document.getElementById('email').value.trim();
      const confirm = document.getElementById('confirm_email').value.trim();
      
      if (email !== confirm) {
        e.preventDefault();
        alert('⚠️ Les adresses e-mail ne correspondent pas.');
        return;
      }

      // Vérification reCAPTCHA
      if (!recaptchaVerified) {
        e.preventDefault();
        document.getElementById('recaptcha-error').style.display = 'block';
        alert('⚠️ Veuillez cocher la case "Je ne suis pas un robot".');
        return;
      }

      // Désactiver le bouton pour éviter les double soumissions
      document.getElementById('submitBtn').disabled = true;
      document.getElementById('submitBtn').innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Envoi en cours...';
    });
  });

  // Réactiver le bouton si l'utilisateur revient en arrière
  window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
      document.getElementById('submitBtn').disabled = !recaptchaVerified;
      document.getElementById('submitBtn').innerHTML = '&#128233; Envoyer la demande';
    }
  });
</script>

<?php include('footer.php'); ?>
