<?php
require_once "../includes/common.php";
require_once CLASSES_DIR . "Auth.php";

//the authentication class is static so there is no need to create an instance of the class
Authentication::protect();

$message = "";

if (isset($_POST["deleteProduct"])) {
  $product = new Product($db);
  $productID = intval($_POST["productId"]);

  if($product->deleteProduct($productID)){
    $message = "Deleted";
    header("Location: view-products.php");
    exit();
  } else {
    $message = "Something went wrong";
  }


  
} else {
  header("Location: view-products.php");
  exit();
}

$title = "Editing product: " . (!empty($productName) ? $productName : "Unknown");
$scripts = [
    "validateForm.js"
];


//start buffer
ob_start();

include_once TEMPLATES_DIR . "admin/_editProduct.html.php";

$content = ob_get_clean();
include_once LAYOUT_TEMPLATES_DIR . "_admin.html.php";
?>