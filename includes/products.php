<?php
    // Fetch featured products
    $sql = <<<SQL
    SELECT	itemId, itemName, photo, price, salePrice, description
    FROM	  item
    WHERE   featured = 1
    SQL;

    // Prepare the statement
    $stmt = $db->prepareStatement($sql);

    // Execute query (get the featured products)
    $featuredProducts = $db->executeSQL($stmt);


    // Fetch products by category

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

    if (!empty($_GET["id"])) {
        // Get the ID (and sanitise/validate it)
        $categoryId = intval($_GET["id"]);

        // Fetch category name
        $sql = <<<SQL
                SELECT categoryName 
                FROM category 
                WHERE categoryId = :categoryId
                SQL;

        $stmt = $db->prepareStatement($sql);
        $stmt->bindValue(":categoryId", $categoryId, PDO::PARAM_INT);
        $categoryResult = $db->executeSQL($stmt);
        $categoryName = $categoryResult[0]['categoryName'] ?? 'Unknown';


        // Count total products in this category
        $sql = <<<SQL
                SELECT COUNT(*) AS total 
                FROM item 
                WHERE categoryId = :categoryId
                SQL;
        $stmt = $db->prepareStatement($sql);
        $stmt->bindValue(":categoryId", $categoryId, PDO::PARAM_INT);
        $totalResult = $db->executeSQL($stmt);
        $totalProducts = $totalResult[0]["total"];

        // Calculate total pages
        $totalPages = ceil($totalProducts / $itemsPerPage);

        // Early validation: page must be in range
        if ($currentPage > $totalPages && $totalPages > 0) {
            header("Location: products.php?id={$categoryId}&page={$totalPages}");
            exit;
        } elseif ($currentPage < 1) {
            header("Location: products.php?id={$categoryId}&page=1");
            exit;
        }

        // Calculate offset
        $offset = ($currentPage - 1) * $itemsPerPage;

        // Fetch paginated products
        $sql = <<<SQL
                SELECT	itemId, itemName, photo, price, salePrice, description
                FROM    item
                    INNER JOIN category 
                    ON item.categoryId = category.categoryId
                WHERE   category.categoryId = :categoryId
                LIMIT :limit OFFSET :offset
                SQL;

        // Prepare the statement
        $stmt = $db->prepareStatement($sql);

        $stmt->bindValue(":categoryId", $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(":limit", $itemsPerPage, PDO::PARAM_INT);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);

        // Execute query
        $products = $db->executeSQL($stmt);

    }