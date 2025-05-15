<?php

  require_once "includes/common.php";
  require_once "includes/featuredProducts.php";

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
  include_once TEMPLATES_DIR . "_indexPage.html.php";

  // Stop output buffering - store output into the $content variable
  $content = ob_get_clean();

  // Include the main layout template
  include_once TEMPLATES_DIR . "_layout.html.php";