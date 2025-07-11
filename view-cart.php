<?php

  // Dependencies
  require_once "includes/common.php";

  $products = $cart->getItemsForDisplay($db);
  $productCount = $cart->count();
  $subtotal = $cart->calculateTotal();
  $cartClass = "cart-page";
  $displayType = "in-cart";

  // Config
  $title = "Your Cart";
  $styles = [
    "products.css"
  ];

  $scripts = [
    "spinner.js"
  ];

  ob_start();

  // Include the page-specific template
  include_once PAGE_TEMPLATES_DIR . "_viewCart.html.php";

  // Stop output buffering - store output into the $content variable
  $content = ob_get_clean();

  // Include the main layout template
  include_once LAYOUT_TEMPLATES_DIR . "_main.html.php";