<section class="section-constrained flex-column gap">
<h2 class="strip strip--mobile"><?= $title ?></h2>

<?php if ($success): ?>
  <div id="confirmationMessage">
    <img src="assets/send.png" alt="">
    <p>Thank you! We have received your information and will keep you updated.</p>
    <p>Stay tuned</p>
  </div>
<?php else: ?>
  <form id="contactForm" class="mobile-padding" action="contact-us.php" method="post" novalidate>

    <div class="input-group">
      <div class="input-container">
        <input class="floating" type="text" id="firstName" name="firstName" placeholder="First name" required <?= setValue("firstName") ?>>
        <label class="sr-only" for="firstName">First name</label>

        <?php if (!empty($errors["firstName"])): ?>
          <div class="error-message">
            <?= $errors["firstName"] ?>
          </div>
        <?php endif ?>

      </div>
      <div class="input-container">
        <input class="floating" type="text" id="lastName" name="lastName" placeholder="Last name" required <?= setValue("lastName") ?>>
        <label class="sr-only" for="lastName">Last name</label>

        <?php if (!empty($errors["lastName"])): ?>
          <div class="error-message">
            <?= $errors["lastName"] ?>
          </div>
        <?php endif ?>

      </div>
    </div>

    <div class="input-group">
      <div class="input-container">
        <input class="floating" type="tel" name="contactNumber" id="contactNumber" placeholder="Contact number" <?= setValue("contactNumber") ?>>
        <label class="sr-only" for="contactNumber">Contact number</label>
      </div>

      <div class="input-container">
        <input class="floating" type="email" name="emailAddress" id="emailAddress" placeholder="Email address" required <?= setValue("emailAddress") ?>>
        <label class="sr-only" for="emailAddress">Email address</label>

        <?php if (!empty($errors["email"])): ?>
          <div class="error-message">
            <?= $errors["email"] ?>
          </div>
        <?php endif ?>

      </div>
    </div>

    <div class="input-single">

      <textarea class="floating" id="question" name="question" rows="3" placeholder="Type your question or message here.."><?= getEncodedValue("question") ?></textarea>
      <label class="sr-only" for="question">Type your question or message here..</label>

    </div>

    <button type="submit" name="submitComingSoon">
      <img src="./assets/images/icons/send.png" alt="">
    </button>

  </form>
<?php endif ?>

</section>

