<?php
require_once "../includes/common.php";
require_once INCLUDES_DIR . "helpers.php";
require_once CLASSES_DIR . "Auth.php";

Authentication::protect();

$message = "";

if (isset($_GET["id"]) || isset($_POST["editProduct"])) {
    $product = new Product($db);

    if (isset($_GET["id"])) {
        $productID = intval($_GET["id"]);
    } elseif (isset($_POST["productID"])) {
        $productID = intval($_POST["productID"]);
    } else {
        $productID = 0;
    }

    $product->loadSingleProductByID($productID);

    if (isset($_POST["editProduct"])) {
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

        // Use current image as default
        $photoPath = $product->getPhoto();

        // Handle file upload only if a file is provided
        if (isset($_FILES["productImage"]) && $_FILES["productImage"]["error"] !== UPLOAD_ERR_NO_FILE) {
            $productImage = basename($_FILES["productImage"]["name"]);
            $targetDirectory = IMAGES_DIR . "products/";
            $targetPath = $targetDirectory . $productImage;

            $validExtensions = ["jpg", "jpeg", "gif", "png"];
            $fileExtension = strtolower(pathinfo($productImage, PATHINFO_EXTENSION));

            if (!in_array($fileExtension, $validExtensions)) {
                $errors["productImage"] = "Invalid file extension. Allowed: " . implode(", ", $validExtensions);
            }

            if ($_FILES["productImage"]["size"] > 2 * 1024 * 1024) {
                $errors["productImage"] = "Image is too large (max 2MB).";
            }

            if (!isset($errors["productImage"])) {
                if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetPath)) {
                    $photoPath = $productImage;
                } else {
                    $errors["productImage"] = "Failed to move uploaded file.";
                }
            }
        }

        if (empty($errors)) {
            $product = new Product($db);
            $product->setProductName($productName);
            $product->setCategory($category);
            $product->setImage($photoPath);
            $product->setDescription($productDescription);
            $product->setPrice($productPrice);
            if ($productSalePrice) {
                $product->setSalePrice($productSalePrice);
            }
            $product->setFeatured($productFeatured);

            if ($product->update($productID)) {
                $message = "Product has been updated.";
            }
        }
    }

    $categoryID = $product->getCategory();

    $productInfo = [
        "productName" => $product->getProductName(),
        "categoryId" => $categoryID,
        "categoryName" => $product->getCategoryName($categoryID),
        "image" => $product->getPhoto(),
        "productDescription" => $product->getDescription(),
        "productPrice" => $product->getPrice(),
        "productSalePrice" => $product->getSalePrice(),
        "featured" => $product->getFeatured()
    ];

} else {
    header("Location: view-categories.php");
    exit();
}

$title = "Editing product: " . (!empty($productName) ? $productName : "Unknown");
$scripts = ["validateForm.js"];

ob_start();
include_once TEMPLATES_DIR . "admin/_editProduct.html.php";
$content = ob_get_clean();
include_once LAYOUT_TEMPLATES_DIR . "_admin.html.php";
?>
