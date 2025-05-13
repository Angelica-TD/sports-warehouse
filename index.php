<?php
  require_once "includes/common.php";

  // Config
  $title = "Home";
  $companyName = "Sports Warehouse";
  $scripts = [
    "subscribe.js"
  ];

  ob_start();

  $sql = <<<SQL
    SELECT	itemId, itemName, photo, price, salePrice, description
    FROM	  item
    WHERE   featured = 1
  SQL;

  // Prepare the statement
  $stmt = $db->prepareStatement($sql);

  // Execute query (get the featured products)
  $featuredProducts = $db->executeSQL($stmt);

  // Include the page-specific template
  include_once "templates/_indexPage.html.php";

  // Stop output buffering - store output into the $content variable
  $content = ob_get_clean();

  // Include the main layout template
  include_once "templates/_layout.html.php";