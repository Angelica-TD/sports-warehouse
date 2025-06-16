<section class="section-constrained flex-column gap">
  <h2 class="strip strip--mobile strip--bglightblue"><?= $title ?></h2>

  <div class="two-columns">

    <?php include BLOCK_TEMPLATES_DIR . "_checkoutForm.html.php"; ?>

    <div class="cart-summary checkout">

      <?php if (isset($_SESSION['infoSaved'])): ?>

      <?php include BLOCK_TEMPLATES_DIR . "_customerInfo.html.php"; ?>

      <?php endif ?>

      <h3>
        Order summary
      </h3>

      <?php include BLOCK_TEMPLATES_DIR . "_productsSummary.html.php"; ?>

    </div>

  </div> 

</section>
