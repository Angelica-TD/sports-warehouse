<?php
require_once "../includes/common.php";
require_once "../includes/pagination.php";
require_once CLASSES_DIR . "Auth.php";

//the authentication class is static so there is no need to create an instance of the class
Authentication::protect();

$message = "";

$currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$result = $product->getAllProducts(null, $currentPage, 20);

$products = $result['products'];
$totalProducts = $result['totalProducts'];
$totalPages = $result['totalPages'];

// Redirect if page out of range
if ($currentPage != $result['currentPage']) {
    header("Location: view-products.php?page=" . $result['currentPage']);
    exit;
}

$title = "View / edit products";
$scripts = [
    "validateForm.js"
];

//start buffer
ob_start();


include_once TEMPLATES_DIR . "admin/_listAllProducts.html.php";


$content = ob_get_clean();
include_once LAYOUT_TEMPLATES_DIR . "_admin.html.php";
?>