<?php
require_once "../includes/common.php";
require_once CLASSES_DIR . "Auth.php";
require_once CLASSES_DIR . "Category.php";

// Authentication is static, no instance needed
Authentication::protect();

$message = "";

if (isset($_POST["deleteCategory"])) {
    $category = new Category($db);
    $categoryID = intval($_POST["categoryId"]);

    try {
        if ($category->deleteCategory($categoryID)) {
            // Deletion successful
            $message = "Category deleted successfully.";
            header("Location: view-categories.php?message=" . urlencode($message));
            exit();
        } else {
            // Deletion failed due to foreign key constraint (products exist)
            $message = "Cannot delete category: it contains products. Please reassign or delete those products first.";
        }
    } catch (Exception $ex) {
        $message = "Something went wrong: " . $ex->getMessage();
    }

    // If here, something prevented deletion - show the edit page with message
    $category->getCategory($categoryID);

    $categoryName = $category->getCategoryName();

    $title = "Editing category: " . (!empty($categoryName) ? $categoryName : "Unknown");
    $scripts = [
        "validateForm.js"
    ];

    // Start buffer
    ob_start();

    include_once TEMPLATES_DIR . "admin/_editCategory.html.php";

    $content = ob_get_clean();
    include_once LAYOUT_TEMPLATES_DIR . "_admin.html.php";

} else {
    header("Location: view-categories.php");
    exit();
}
?>
