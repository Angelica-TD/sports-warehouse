<?php

    if (!empty($_GET["id"])) {
        // Get the ID (and sanitise/validate it)
        $itemId = intval($_GET["id"]);
        $categoryId = null;

        // Fetch item
        $sql = <<<SQL
                SELECT	itemId, itemName, photo, price, salePrice, description
                FROM    item
                WHERE   itemId = :itemId
                SQL;

        $stmt = $db->prepareStatement($sql);
        $stmt->bindValue(":itemId", $itemId, PDO::PARAM_INT);
        $item = $db->executeSQLReturnOneRow($stmt);
        $isOnSale = isset($item["salePrice"]) && $item["salePrice"] > 0;
        $price = $isOnSale ? $item["salePrice"] : $item["price"];
        $priceFormatted = sprintf('$%1.2f', $price);
        $originalPriceFormatted = $isOnSale ? sprintf('$%1.2f', $item["price"]) : null;

    } else {

        // No product ID given - redirect to home
        header("Location: index.php");
        exit;
    
    }