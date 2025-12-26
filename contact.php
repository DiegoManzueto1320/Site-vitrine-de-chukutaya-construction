<?php include('header.php'); ?>



<style>

  main.contact-page { background-color: #f8f9fa; padding: 60px 20px; }

  .contact-card { border: none; border-radius: 20px; overflow: hidden; transition: all 0.3s ease; background: #fff; }

  .contact-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }

  .contact-card h2 { font-size: 1.9rem; letter-spacing: 0.5px; }

  label span { font-size: 1.1rem; }

  textarea { resize: none; }

  .form-check-label a { color: var(--bs-primary); text-decoration: underline; }

  .contact-info { margin-top: 60px; padding: 40px; background: white; border-radius: 20px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); }

  .contact-info p { margin-bottom: 8px; }

  .contact-info a { text-decoration: none; }

  @media (max-width: 768px) { .contact-card { margin-bottom: 30px; } }

</style>



<main class="contact-page container">

  <div class="card contact-card shadow-lg mb-5">

    <div class="card-body p-4 p-md-5">

      <h2 class="text-center mb-4 fw-bold text-primary">

        <span class="me-2">&#9993;</span>Contactez-nous

      </h2>

      <p class="text-center fs-5 text-secondary mb-4">

        Remplissez le formulaire ci-dessous pour toute demande d’information ou de partenariat.<br>

        <span class="text-success">Nous vous répondrons sous 24h ouvrées.</span>

      </p>



      <form id="contactForm" action="send_message.php" method="POST" novalidate>

        <div class="row g-4">

          <div class="col-md-4">

            <label for="name" class="form-label fw-semibold">

              <span class="text-primary">&#128100;</span> Nom complet <span class="text-danger">*</span>

            </label>

            <input type="text" id="name" name="name" class="form-control" required placeholder="Votre nom complet">

          </div>



          <div class="col-md-4">

            <label for="email" class="form-label fw-semibold">

              <span class="text-primary">&#9993;</span> Email <span class="text-danger">*</span>

            </label>

            <input type="email" id="email" name="email" class="form-control" required placeholder="exemple@domaine.com">

          </div>



          <div class="col-md-4">

            <label for="confirm_email" class="form-label fw-semibold">

              <span class="text-primary">&#9993;</span> Confirmez l’email <span class="text-danger">*</span>

            </label>

            <input type="email" id="confirm_email" name="confirm_email" class="form-control" required placeholder="Confirmez votre email">

          </div>

        </div>



        <div class="row g-4 mt-3">

          <div class="col-md-4">

            <label for="phone" class="form-label fw-semibold">

              <span class="text-success">&#128222;</span> Téléphone <span class="text-danger">*</span>

            </label>

            <input type="tel" id="phone" name="phone" class="form-control" required pattern="^\+?\d{9,15}$" placeholder="+243 822 987 259">

          </div>



          <div class="col-md-8">

            <label for="subject" class="form-label fw-semibold">

              <span class="text-warning">&#128172;</span> Sujet <span class="text-danger">*</span>

            </label>

            <input type="text" id="subject" name="subject" class="form-control" required placeholder="Sujet de votre message">

          </div>

        </div>



        <div class="mb-3 mt-4">

          <label for="message" class="form-label fw-semibold">

            <span class="text-primary">&#9997;</span> Message <span class="text-danger">*</span>

          </label>

          <textarea id="message" name="message" class="form-control" rows="5" required placeholder="Votre message..."></textarea>

        </div>



        <div class="form-check mb-4">

          <input type="checkbox" class="form-check-input" id="rgpd" name="rgpd" required>

          <label class="form-check-label" for="rgpd">

            J’accepte que mes données soient utilisées pour me recontacter.

            <a href="#">En savoir plus</a>

          </label>

        </div>



        </div>



        <div class="text-center">

          <button type="submit" id="submitBtn" class="btn btn-primary px-5 py-2 fw-semibold rounded-pill shadow-sm" disabled>

            <span class="me-2">&#10148;</span>Envoyer le message

          </button>

        </div>

      </form>

    </div>

  </div>



  <section class="contact-info text-center">

    <h4 class="fw-bold text-primary mb-3">

      <span class="me-2">&#128205;</span>Nos coordonnées

    </h4>

    <p><strong>Adresse :</strong> Ville de Kinshasa, Avenue Cocotier, n°07, Commune de la Gombe</p>

    <a href="https://www.google.com/maps/search/?api=1&query=Ville+de+Kinshasa,+Avenue+Cocotier,+n°07,+Commune+de+la+Gombe" 

       target="_blank" class="text-primary text-decoration-underline">

      Localiser sur Google Maps

    </a>



    <p class="mt-3"><strong>Téléphones :</strong>

      <span class="text-success">+243 819 536 264</span> / 

      <span class="text-success">+243 822 987 259</span>

    </p>



    <p><strong>Email :</strong> 

      <a href="mailto:chekinvest.cd@gmail.com" class="text-primary">chekinvest.cd@gmail.com</a>

    </p>



    <p><strong>WhatsApp :</strong> 

      <a href="https://wa.me/243837090571" target="_blank" class="text-success">+243 837 090 571</a>

    </p>



    <p><strong>Facebook :</strong> 

      <a href="https://www.facebook.com/profile.php?id=61582376875422" target="_blank" class="text-primary">

        CIC Chekutaya Investment Construction

      </a>

    </p>

  </section>

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

    recaptchaVerified = false;

  }



  // Validation du formulaire

  document.getElementById('contactForm').addEventListener('submit', function(e) {

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



  // Réactiver le bouton si l'utilisateur revient en arrière

  window.addEventListener('pageshow', function(event) {

    if (event.persisted) {

      document.getElementById('submitBtn').disabled = !recaptchaVerified;

      document.getElementById('submitBtn').innerHTML = '<span class="me-2">&#10148;</span>Envoyer le message';

    }

  });

</script>



<?php include('footer.php'); ?>


