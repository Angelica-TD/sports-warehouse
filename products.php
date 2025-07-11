<?php

  // Dependencies
  require_once "includes/common.php";
  require_once "includes/pagination.php";

  // add to cart
  if(isset($_POST["cartAction"]))
  {
    
    //check product id and qty are not empty
    if(!empty($_POST["productId"]) && isset($_POST["quantity"])){
      $productId = $_POST["productId"];
      $quantity = $_POST["quantity"];

      // load product from DB
      $product->loadSingleProductByID($productId);
      
      // create a new cart item
      $cartProduct = new CartItem($product->getProductName(), $product->getFinalPrice(), $productId, $quantity);
      
      if($_POST["cartAction"] === "addToCart"){

        // add it to shopping cart or update quantity
        $cart->addItem($cartProduct);

      }elseif($_POST["cartAction"] === "updateItemInCart"){ 
        // echo $quantity;
        $cart->updateQuantity($cartProduct, $quantity);
      }
      else {

        $cart->removeItem($cartProduct);
      
      }      

      //save shopping cart back into session
      $_SESSION["cart"] = $cart;

      // echo "<pre>";
      // print_r($_SESSION["cart"]);
      // print_r($cart->count());
      // echo "</pre>";

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
    $result = $product->getProductsByCategory($categoryId, $cart, $currentPage);
    $categoryName = $product->getCategoryName($categoryId);
  } else {
    $result = $product->getAllProducts($cart, $currentPage);
    $categoryName = "All Products";
  }

  $activeCategoryId = $product->getActiveProductCategory();

  $products = $result['products'];
  $totalProducts = $result['totalProducts'];
  $totalPages = $result['totalPages'];

  // Redirect if page out of range
  if ($currentPage <= 0 || $currentPage > $totalPages) {
      header("Location: products.php");
      exit;
  }

  // Config
  $title = "Shop $categoryName";
  $styles = [
    "products.css"
  ];

  $scripts = [
    "spinner.js"
  ];

  ob_start();

  // Include the page-specific template
  include_once PAGE_TEMPLATES_DIR . "_products.html.php";

  // Stop output buffering - store output into the $content variable
  $content = ob_get_clean();

  // Include the main layout template
  include_once LAYOUT_TEMPLATES_DIR . "_main.html.php";