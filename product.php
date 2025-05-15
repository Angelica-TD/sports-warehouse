<?php

  // Dependencies
  require_once "includes/common.php";
  require_once "classes/ProductAccess.php";

  if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
      header("Location: index.php");
      exit;
  }

  $productAccess = new ProductAccess($db);

  $itemId = (int) $_GET['id'];

  $item = $productAccess->getSingleProductByID($itemId);
  $priceFormatted = $item['priceFormatted'];
  $originalPriceFormatted = $item['originalPriceFormatted'];
  $isOnSale = $item['isOnSale'];

  // Config
  $title = $item["itemName"];
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