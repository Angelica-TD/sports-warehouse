<?php

  // Define constant that points to the root directory of the website, which helps when including files throughout your code when you don't know what the current directory is
  // ROOT_DIR will point to the "sports-warehouse" folder
  // INCLUDES_DIR will point to the "sports-warehouse/includes" folder
  // TEMPLATES_DIR will point to the "sports-warehouse/templates" folder
  // SCRIPTS_DIR will point to the "sports-warehouse/assets/js" folder
  define("ROOT_DIR", __DIR__ . "/../");
  define("INCLUDES_DIR", ROOT_DIR . "includes/");
  define("CLASSES_DIR", ROOT_DIR . "classes/");
  define("TEMPLATES_DIR", ROOT_DIR . "templates/");
  define("LAYOUT_TEMPLATES_DIR", ROOT_DIR . "templates/layouts/");
  define("PAGE_TEMPLATES_DIR", ROOT_DIR . "templates/pages/");
  define("BLOCK_TEMPLATES_DIR", ROOT_DIR . "templates/components/");
  define("SCRIPTS_DIR", ROOT_DIR . "assets/js/");
  define("STYLES_DIR", ROOT_DIR . "assets/css/");
  define("IMAGES_DIR", ROOT_DIR . "assets/images/");
  define('COMPANY_NAME', 'Sports Warehouse');

  // TODO: Enable .env
  $config = require INCLUDES_DIR . 'secrets.php';

  // Database connection (create DBAccess instance in the $db variable)
  require_once INCLUDES_DIR . "database.php";

  // Include ShoppingCart class which is used in every page
  require_once CLASSES_DIR . "CartItem.php";
  require_once CLASSES_DIR . "ShoppingCart.php";
  require_once CLASSES_DIR . "Product.php";

  $product = new Product($db);
  $categories = $product->getAllProductCategories();
  $activeCategoryId = $product->getActiveProductCategory();

  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (isset($_SESSION["cart"])) {
    $cart = $_SESSION["cart"];
  } else {
    $cart = new ShoppingCart();
    $_SESSION["cart"] = $cart;
  }

  $itemCount = $cart->count();
  $displayType = "list";
  $cartClass = "";