<?php

  // Dependencies
  require_once "includes/common.php";

  // Fetch featured products
  $products = $product->getFeaturedProducts($cart);

  // Config
  $title = "Home";
  
  $styles = [
    "products.css"
  ];

  $scripts = [
    "subscribe.js",
    "spinner.js"
  ];

  ob_start();

  // Include the page-specific template
  include_once PAGE_TEMPLATES_DIR . "_index.html.php";

  // Stop output buffering - store output into the $content variable
  $content = ob_get_clean();

  // Include the main layout template
  include_once LAYOUT_TEMPLATES_DIR . "_main.html.php";