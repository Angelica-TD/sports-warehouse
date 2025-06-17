<?php
require_once "includes/common.php";
require_once "classes/Auth.php";
$title = "Success";
$pageHeading = "Login Successful";
$loginName = $_SESSION["username"];
//start buffer
ob_start();
// Include the page-specific template
include_once BLOCK_TEMPLATES_DIR . "_success.html.php";

// Stop output buffering - store output into the $content variable
$content = ob_get_clean();

// Include the main layout template
include_once LAYOUT_TEMPLATES_DIR . "_main.html.php";
?>