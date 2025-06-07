<?php

  // Dependencies
  require_once "includes/common.php";
  require_once "classes/SaveOrderToDB.php";
  require_once "classes/ShoppingCart.php";

  $cart = new ShoppingCart($db);

  // Fetch products in the cart
  $products = $cart->getItems();

  // Config
  $title = "Your Cart";

  $styles = [
    "products.css"
  ];

  $showAddToCart = false;
  $viewCartPage = true;

  ob_start();

  // Include the page-specific template
  include_once PAGE_TEMPLATES_DIR . "_viewCart.html.php";

  // Stop output buffering - store output into the $content variable
  $content = ob_get_clean();

  // Include the main layout template
  include_once LAYOUT_TEMPLATES_DIR . "_main.html.php";