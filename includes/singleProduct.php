<?php

    // Dependencies
    require_once ROOT_DIR . "classes/ProductAccess.php";

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header("Location: index.php");
        exit;
    }

    $productAccess = new ProductAccess($db);

    $itemId = (int) $_GET['id'];

    $item = $productAccess->getSingleProductByID($itemId);
    $priceFormatted = $item['priceFormatted'];
    $originalPriceFormatted = $item['originalPriceFormatted'];
    $isOnSale = $item['isOnSale'];