<?php

    // Dependencies
    require_once ROOT_DIR . "classes/ProductAccess.php";

    $productAccess = new ProductAccess($db);

    // Fetch featured products
    $products = $productAccess->getFeaturedProducts();