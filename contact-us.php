<?php

  require_once "includes/common.php";
  require_once "includes/helpers.php";
  require_once "includes/contactUs.php";

  $success = false;

  // Config
  $title = "Contact us";
  $styles = [
    "contact.css"
  ];

  ob_start();

  // Include the page-specific template
  include_once PAGE_TEMPLATES_DIR . "_contactUs.html.php";

  // Stop output buffering - store output into the $content variable
  $content = ob_get_clean();

  // Include the main layout template
  include_once TEMPLATES_DIR . "_layout.html.php";