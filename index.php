<?php

  // Dependencies
  require_once "includes/common.php";
  require_once "classes/ProductAccess.php";

  $productAccess = new ProductAccess($db);

  // Fetch featured products
  $products = $productAccess->getFeaturedProducts();

  // Config
  $title = "Home";
  
  $styles = [
    "products.css"
  ];

  $scripts = [
    "subscribe.js"
  ];

  ob_start();

  // Include the page-specific template
  include_once PAGE_TEMPLATES_DIR . "_index.html.php";

  // Stop output buffering - store output into the $content variable
  $content = ob_get_clean();

  // Include the main layout template
  include_once TEMPLATES_DIR . "_layout.html.php";