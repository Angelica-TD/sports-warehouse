<?php
    
    // Check if on search.php or products.php
    // Get current script name (e.g., search.php or products.php)
    $currentPageUrl = basename($_SERVER['PHP_SELF']);

    // Define the base URL for pagination based on the current page type
    if ($currentPageUrl === "search.php" && !empty($_GET['search-product'])) {

        $searchTerm = urlencode(trim($_GET['search-product']));
        
        $baseUrl = "search.php?search-product={$searchTerm}&page=";
    
    } elseif ($currentPageUrl === 'products.php') {
        if(isset($_GET["id"])){
            $baseUrl = "products.php?id=" . urlencode($_GET['id']) . "&page=";
        } else {
            $baseUrl = "products.php?page=";
        }
        
    } elseif ($currentPageUrl === 'view-products.php') {
        
        $baseUrl = "view-products.php?page=";
        
    }