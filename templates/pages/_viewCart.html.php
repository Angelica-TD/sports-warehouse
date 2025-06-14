<section class="section-constrained flex-column gap">
  <h2 class="strip strip--mobile strip--bglightblue strip--with-icon view-cart view-cart--left"><?= $title ?></h2>

  <div class="two-columns">

    <?php include BLOCK_TEMPLATES_DIR . "_products.html.php"; ?>

    <div class="cart-summary">

      <?php if ($productCount > 0): ?>

      <div class="cart-info">
        <table>

          <tr>
            
            <td>
              Total items:
            </td>

            <td>
              <?= $productCount ?>
            </td>

          </tr>

          <tr>

            <td>
              Subtotal:
            </td>

            <td>
              <?= sprintf('$%1.2f', $subtotal) ?>
            </td>

          </tr>

        </table>
      </div>

      <a href="checkout.php" class="btn btn--darkblue proceed-checkout">
        Proceed to checkout
      </a>

      <?php endif ?>

    </div>

  </div> 

</section>
