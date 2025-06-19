<?php
require_once "../includes/common.php";
require_once CLASSES_DIR . "Auth.php";

Authentication::protect();

$message = "";

if (isset($_POST["addProduct"])) {
    $errors = [];

    $productName = $_POST["productName"] ?? "";
    $category = $_POST["category"] ?? "";
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

    // Default image value
    $photoPath = null;

    // File upload
    if (isset($_FILES["productImage"]) && $_FILES["productImage"]["error"] !== UPLOAD_ERR_NO_FILE) {
        $targetDirectory = IMAGES_DIR . "products/";
        $fileName = basename($_FILES["productImage"]["name"]);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $validExtensions = ["jpg", "jpeg", "gif", "png"];

        if (!in_array($fileExtension, $validExtensions)) {
            $errors["productImage"] = "Invalid file extension. Allowed: " . implode(", ", $validExtensions);
        }

        if ($_FILES["productImage"]["size"] > 2 * 1024 * 1024) {
            $errors["productImage"] = "Image is too large (max 2MB).";
        }

        if (!isset($errors["productImage"])) {
            // Optional: give it a unique name to prevent overwrites
            $uniqueName = uniqid("img_", true) . "." . $fileExtension;
            $moveTo = $targetDirectory . $uniqueName;

            if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $moveTo)) {
                $photoPath = $uniqueName;
            } else {
                $errors["productImage"] = "Uploaded file could not be moved.";
            }
        }
    }

    if (empty($errors)) {
        $product = new Product($db);
        $product->setProductName($productName);
        $product->setCategory($category);
        $product->setImage($photoPath); // this may be null if no image uploaded
        $product->setDescription($productDescription);
        $product->setPrice($productPrice);

        if ($productSalePrice) {
            $product->setSalePrice($productSalePrice);
        }

        $product->setFeatured($productFeatured);

        $newProductId = $product->insert();
        if ($newProductId) {
            $message = "Product has been added successfully.";
        }
    }
}

$title = "Add a new product";
$scripts = ["validateForm.js"];

ob_start();
include_once TEMPLATES_DIR . "admin/_addProduct.html.php";
$content = ob_get_clean();
include_once LAYOUT_TEMPLATES_DIR . "_admin.html.php";
?>
