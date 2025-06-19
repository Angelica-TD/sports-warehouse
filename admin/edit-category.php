<?php
require_once "../includes/common.php";
require_once CLASSES_DIR . "Auth.php";
require_once CLASSES_DIR . "Category.php";

//the authentication class is static so there is no need to create an instance of the class
Authentication::protect();

$message = "";

if (isset($_GET["id"]) || isset($_POST["editCategory"])) {
  $category = new Category($db);

  if (isset($_GET["id"])) {
    $categoryID = intval($_GET["id"]);
  } elseif (isset($_POST["categoryID"])) {
    $categoryID = intval($_POST["categoryID"]);
  } else {
    // fallback or error handling if neither is set
    $categoryID = 0;
  }

  $category->getCategory($categoryID);
  

  if (isset($_POST["editCategory"])) {
    $setCategoryName = $category->setCategoryName($_POST["newCategoryName"]);
    $updateCategory = $category->updateCategory($categoryID);
    if ($updateCategory) {
      $message = "Category has been updated";
    }
  }

  $categoryName = $category->getCategoryName();
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