<?php
require_once "../includes/common.php";
require_once CLASSES_DIR . "Auth.php";

//the authentication class is static so there is no need to create an instance of the class
Authentication::protect();

$message = "";

if (isset($_POST["addProduct"])) {

  $errors = [];

  $productName = $_POST["productName"] ?? "";
  $category = $_POST["category"] ?? "";
  $productImage = $_POST["productImage"] ?? null;
  $productDescription = $_POST["productDescription"] ?? "";
  $productPrice = $_POST["productPrice"] ?? null;
  $productSalePrice = $_POST["productSalePrice"] ?? null;
  $productFeatured = $_POST["productFeatured"] ?? "";

  if ($productName === "") {
    $errors["productName"] = "This is required";
  }
  if ($category === "") {
    $errors["category"] = "This is required";
  }
  if (!isset($productPrice)) {
    $errors["productPrice"] = "This is required";
  }

  /* 
    * Photo file upload
    */

  // File upload settings
  $targetDirectory = IMAGES_DIR;
  $fileUploadOptional = true;

  // Skip file upload if no file given and upload is optional
  if (!($fileUploadOptional && $_FILES["productImage"]["error"] === UPLOAD_ERR_NO_FILE)) {

    // Get the filename of the uploaded file (what was it originally called?)
    $fileName = basename($_FILES["productImage"]["name"]);

    // Make sure file is an image (using file extension)
    $validExtensions = ["jpg", "jpeg", "gif", "png"];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    if (!in_array($fileExtension, $validExtensions)) {
      $errors["productImage"] = "Invalid file extension, must be: " . implode(", ", $validExtensions);
    }
    
    // Check file size (not too big) using php.ini config and MAX_FILE_SIZE set in the form
    // You can also manually check the ["size"] of the file
    if (
      $_FILES["productImage"]["error"] === UPLOAD_ERR_FORM_SIZE ||
      $_FILES["productImage"]["error"] === UPLOAD_ERR_INI_SIZE
    ) {
      $errors["productImage"] = "File is too large.";
    }

    // Make sure there are no file errors detected
    if (empty($errors["productImage"])) {

      $moveFrom = $_FILES["productImage"]["tmp_name"];
      $moveTo = $targetDirectory . $fileName;

      // Move uploaded file from the temp location into the target location
      if (move_uploaded_file($moveFrom, $moveTo)) {

        // Success
        $photoPath = $fileName;

      } else {

        // Error
        $errors["productImage"] = "Uploaded file could not be moved.";

      }
    }
  }

  $success = count($errors) === 0 ? true : false;

  if ($success) {
    $product = new Product($db);
    $product->setProductName($productName);
    $product->setCategory($category);
    $product->setImage($productImage);
    $product->setDescription($productDescription);
    $product->setPrice($productPrice);
    if($productSalePrice){
      $product->setSalePrice($productSalePrice);
    }
    
    $product->setFeatured($productFeatured);

    $newProductId = $product->insert();
  }
}

$title = "Add a new product";
$scripts = [
    "validateForm.js"
];


//start buffer
ob_start();

include_once TEMPLATES_DIR . "admin/_addProduct.html.php";

$content = ob_get_clean();
include_once LAYOUT_TEMPLATES_DIR . "_admin.html.php";
?>