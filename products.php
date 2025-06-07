<?php

  // Dependencies
  require_once "includes/common.php";
  require_once "classes/Product.php";
  require_once "includes/pagination.php";

  $product = new Product($db);
    
  // Fetch products by category
  // Get categoryId and page from URL or default values
  $categoryId = isset($_GET['id']) ? intval($_GET['id']) : 0;
  $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

  $result = $product->getProductsByCategory($categoryId, $currentPage);
  $products = $result['products'];
  $totalProducts = $result['totalProducts'];
  $totalPages = $result['totalPages'];

  $categoryName = $product->getCategoryName($categoryId);

  // Redirect if page out of range
  if ($currentPage != $result['currentPage']) {
      header("Location: products.php?id=$categoryId&page=" . $result['currentPage']);
      exit;
  }

  // Config
  $title = "Shop $categoryName";
  $styles = [
    "products.css"
  ];

  ob_start();

  // Include the page-specific template
  include_once PAGE_TEMPLATES_DIR . "_products.html.php";

  // Stop output buffering - store output into the $content variable
  $content = ob_get_clean();

  // Include the main layout template
  include_once LAYOUT_TEMPLATES_DIR . "_main.html.php";