<?php

    // Dependencies
    require_once ROOT_DIR . "classes/ProductAccess.php";

    $productAccess = new ProductAccess($db);
    
    // Fetch products by category
    // Get categoryId and page from URL or default values
    $categoryId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

    $result = $productAccess->getProductsByCategory($categoryId, $currentPage);
    $products = $result['products'];
    $totalProducts = $result['totalProducts'];
    $totalPages = $result['totalPages'];

    $categoryName = $productAccess->getCategoryName($categoryId);

    // Redirect if page out of range
    if ($currentPage != $result['currentPage']) {
        header("Location: products.php?id=$categoryId&page=" . $result['currentPage']);
        exit;
    }
