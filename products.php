<?php

  require_once "includes/common.php";
  require_once "includes/categories.php";
  require_once "includes/products.php";

  // Config
  $title = "Shop $categoryName";
  $styles = [
    "products.css"
  ];

  ob_start();

  // Include the page-specific template
  include_once TEMPLATES_DIR . "_productsListingPage.html.php";

  // Stop output buffering - store output into the $content variable
  $content = ob_get_clean();

  // Include the main layout template
  include_once TEMPLATES_DIR . "_layout.html.php";