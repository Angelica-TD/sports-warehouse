<?php
require_once "../includes/common.php";
require_once CLASSES_DIR . "Auth.php";
require_once CLASSES_DIR . "Category.php";

//the authentication class is static so there is no need to create an instance of the class
Authentication::protect();

$message = "";

if (isset($_POST["addCategory"])) {

  $errors = [];

  $category = new Category($db);
  $categoryName = $_POST["newCategoryName"] ?? "";

  if ($categoryName === "") {
    $errors["newCategoryName"] = "This is required";
  }

  $success = count($errors) === 0 ? true : false;

  if ($success) {
    $category->setCategoryName($categoryName);
    $newCategoryId = $category->insertCategory();
  }


  // header("Location: edit-category.php?id=" . $newCategoryId);
  // exit();
  
}

$title = "Add a new category";
$scripts = [
    "validateForm.js"
];


//start buffer
ob_start();

include_once TEMPLATES_DIR . "admin/_addCategory.html.php";

$content = ob_get_clean();
include_once LAYOUT_TEMPLATES_DIR . "_admin.html.php";
?>