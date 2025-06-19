<?php
require_once "../includes/common.php";
require_once CLASSES_DIR . "Auth.php";

//the authentication class is static so there is no need to create an instance of the class
Authentication::protect();

$message = "";

$title = "View / edit categories";
$scripts = [
    "validateForm.js"
];

//start buffer
ob_start();

include_once TEMPLATES_DIR . "admin/_listAllCategories.html.php";

$content = ob_get_clean();
include_once LAYOUT_TEMPLATES_DIR . "_admin.html.php";
?>