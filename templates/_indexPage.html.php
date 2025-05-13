<section class="section-constrained banner">
  <img class="banner__image" src="./assets/images/banner.png" alt="adidas soccer ball on grass" loading="lazy">
  <div class="banner__overlay">
    <div class="banner__copy">
      <h2 class="overlay__title">View our brand new range of <span>Sports balls</span></h2>
      <a role="button" href="#" class="banner__button orange-fill-hover">Shop now</a>
    </div>
  </div>
</section>

<section class="section-constrained featured-products flex-column gap">
  <h2 class="strip strip--mobile">Featured products</h2>

  <?php
  $products = $featuredProducts;
  include "_products.html.php";
  ?>

</section>

<section class="section-constrained partnerships-container flex-column gap">
  <h2 class="strip strip--mobile">Our brands and partnerships</h2>

  <div class="partnerships-info flex-column gap">
    <div class="intro">
      <p>
        These are some of our top brands and partnerships.
      </p>
      <p class="intro--blue">
        The best of the best is here.
      </p>
    </div>
    <div class="strip strip--bgdarkblue partner-logos">
      <img src="./assets/images/logos/nike.png" alt="nike">
      <img src="./assets/images/logos/adidas.png" alt="adidas">
      <img src="./assets/images/logos/skins.png" alt="skins">
      <img src="./assets/images/logos/asics.png" alt="asics">
      <img src="./assets/images/logos/newbalance.png" alt="new balance">
      <img src="./assets/images/logos/wilson.png" alt="wilson">
    </div>
  </div>
</section>

<?php
  include "_subscribeSection.html.php";
  ?>