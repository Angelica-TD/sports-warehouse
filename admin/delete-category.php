<?php
require_once "../includes/common.php";
require_once CLASSES_DIR . "Auth.php";
require_once CLASSES_DIR . "Category.php";

//the authentication class is static so there is no need to create an instance of the class
Authentication::protect();

$message = "";

if (isset($_POST["deleteCategory"])) {
  $category = new Category($db);
  $categoryID = intval($_POST["categoryId"]);

  if($category->deleteCategory($categoryID)){
    $message = "Deleted";
    header("Location: view-categories.php");
    exit();
  } else {
    $message = "Something went wrong";
  }


  
} else {
  header("Location: view-categories.php");
  exit();
}

$title = "Editing category: " . (!empty($categoryName) ? $categoryName : "Unknown");
$scripts = [
    "validateForm.js"
];


//start buffer
ob_start();

include_once TEMPLATES_DIR . "admin/_editCategory.html.php";

$content = ob_get_clean();
include_once LAYOUT_TEMPLATES_DIR . "_admin.html.php";
?>