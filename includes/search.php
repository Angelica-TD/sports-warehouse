<?php
    // Dependencies
    require_once ROOT_DIR . "classes/ProductAccess.php";

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