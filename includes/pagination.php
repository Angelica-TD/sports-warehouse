<?php
    
    // Check if on search.php or products.php
    // Get current script name (e.g., search.php or products.php)
    $currentPageUrl = basename($_SERVER['PHP_SELF']);

    // Define the base URL for pagination based on the current page type
    if ($currentPageUrl == "search.php" && isset($_GET['search-product'])) {
        // If we're on search.php and the search-product parameter is set
        $baseUrl = 'search.php?search-product=' . urlencode($_GET['search-product']) . '&page=';
    } elseif ($currentPageUrl == "products.php" && isset($categoryId) && $categoryId !== null) {
        // If we're on products.php and categoryId is set (not null)
        $baseUrl = 'products.php?id=' . urlencode($categoryId) . '&page=';
    } else {
        // If neither on search.php with a search-product or products.php with a valid categoryId
        $baseUrl = '';
    }