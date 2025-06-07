<?php

  // Dependencies
  require_once "includes/common.php";
  

  if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
      header("Location: index.php");
      exit;
  }

  $product = new Product($db);

  $itemId = (int) $_GET['id'];

  $product->loadSingleProductByID($itemId);
  $productData = $product->getProductData();

  // Config
  $title = $productData['productName'];
  $styles = [
    "products.css"
  ];

  ob_start();

  // Include the page-specific template
  include_once PAGE_TEMPLATES_DIR . "_singleProduct.html.php";

  // Stop output buffering - store output into the $content variable
  $content = ob_get_clean();

  // Include the main layout template
  include_once LAYOUT_TEMPLATES_DIR . "_main.html.php";