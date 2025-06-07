<?php

  // Dependencies
  require_once "includes/common.php";
  require_once "includes/pagination.php";

  // add to cart
  if(isset($_POST["addToCart"]))
  {
    
    //check product id and qty are not empty
    if(!empty($_POST["productId"]) && !empty($_POST["quantity"])){
      $productId = $_POST["productId"];
      $quantity = $_POST["quantity"];

      // load product from DB
      $product->loadSingleProductByID($productId);

      // create a new cart item
      $cartProduct = new CartItem($product->getProductName(), $quantity, $product->getFinalPrice(), $productId);

      // add it to shopping cart
      $cart->addItem($cartProduct);

      //save shopping cart back into session
      $_SESSION["cart"] = $cart;

      // Get return URL or fallback
      $returnUrl = $_POST['returnUrl'] ?? 'products.php';
      $returnUrl = filter_var($returnUrl, FILTER_SANITIZE_URL);
      header("Location: " . $returnUrl);
      exit;

    }
  }

    
  // Fetch products by category
  // Get categoryId and page from URL or default values
  $categoryId = isset($_GET['id']) ? intval($_GET['id']) : null;
  $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

  if ($categoryId){
    $result = $product->getProductsByCategory($categoryId, $currentPage);
    $categoryName = $product->getCategoryName($categoryId);
  } else {
    $result = $product->getAllProducts();
    $categoryName = "All Products";
  }

  $activeCategoryId = $product->getActiveProductCategory();

  $products = $result['products'];
  $totalProducts = $result['totalProducts'];
  $totalPages = $result['totalPages'];

  // Redirect if page out of range
  if ($currentPage != $result['currentPage']) {
      header("Location: products.php?id=$categoryId&page=" . $result['currentPage']);
      exit;
  }

  // Config
  $title = "Shop $categoryName";
  $styles = [
    "products.css"
  ];

  ob_start();

  // Include the page-specific template
  include_once PAGE_TEMPLATES_DIR . "_products.html.php";

  // Stop output buffering - store output into the $content variable
  $content = ob_get_clean();

  // Include the main layout template
  include_once LAYOUT_TEMPLATES_DIR . "_main.html.php";