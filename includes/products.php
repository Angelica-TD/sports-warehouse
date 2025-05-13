<?php
    // Define
    $sql = <<<SQL
    SELECT	itemId, itemName, photo, price, salePrice, description
    FROM	  item
    WHERE   featured = 1
    SQL;

    // Prepare the statement
    $stmt = $db->prepareStatement($sql);

    // Execute query (get the featured products)
    $featuredProducts = $db->executeSQL($stmt);