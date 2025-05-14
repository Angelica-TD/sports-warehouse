<?php

    // Set number of products per page
    $itemsPerPage = 10;

    // Get current page from URL, default to 1
    $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

    // Default values
    $products = [];
    $totalProducts = 0;
    $totalPages = 0;
    $categoryName = '';
    $categoryId = null;

    if (isset($_GET["search-product"])){
        $search = $_GET["search-product"];

        $sql = <<<SQL
                SELECT      COUNT(*) AS total 
                FROM        item 
                WHERE       itemName LIKE :search
                OR          description LIKE :search
                SQL;

        $stmt = $db->prepareStatement($sql);
        $stmt->bindValue(":search", "%{$search}%", PDO::PARAM_STR);
        $totalResult = $db->executeSQL($stmt);
        $totalProducts = $totalResult[0]["total"];

        // Calculate total pages
        $totalPages = ceil($totalProducts / $itemsPerPage);

        // Early validation: page must be in range
        if ($currentPage > $totalPages && $totalPages > 0) {
            header("Location: search.php?search={$categoryId}&page={$totalPages}");
            exit;
        } elseif ($currentPage < 1) {
            header("Location: search.php?search={$categoryId}&page=1");
            exit;
        }

        // Calculate offset
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Fetch paginated products
        $sql = <<<SQL
                SELECT	itemId, itemName, photo, price, salePrice, description
                FROM        item 
                WHERE       itemName LIKE :search
                OR          description LIKE :search
                LIMIT       :limit
                OFFSET      :offset
                SQL;

        // Prepare the statement
        $stmt = $db->prepareStatement($sql);

        $stmt->bindValue(":search", "%{$search}%", PDO::PARAM_STR);
        $stmt->bindValue(":limit", $itemsPerPage, PDO::PARAM_INT);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);

        // Execute query
        $products = $db->executeSQL($stmt);
    } else {

        // Redirect to home
        header("Location: index.php");
        exit;
    
    }
