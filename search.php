<?php

  // Dependencies
  require_once "includes/common.php";
  require_once "classes/ProductAccess.php";
  require_once "includes/pagination.php";

  $productAccess = new ProductAccess($db);

  // Fetch products by search term

  // Get searchTerm and current page from URL
  $searchTerm = isset($_GET['search-product']) ? trim($_GET['search-product']) : '';
  $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

  // Redirect to home if search term is empty
  if (empty($searchTerm)) {
    header("Location: index.php");
    exit;
  }

  // Fetch products and pagination info from ProductAccess
  $result = $productAccess->getProductsBySearchTerm($searchTerm, $currentPage);

  $products = $result['products'];
  $totalProducts = $result['totalProducts'];
  $totalPages = $result['totalPages'];
  $currentPage = $result['currentPage'];

  // Config
  $title = "Search results for $searchTerm";
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
