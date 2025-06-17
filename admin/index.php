<?php

require_once "../includes/common.php";
require_once CLASSES_DIR . "Auth.php";

$title = "Admin";
$pageHeading = "This is for logged in users only";

$loginName = $_SESSION["username"] ?? "";

// $action = $_GET["action"] ?? "";
// $adminActions = [
//     "change-password" => "_changePassword.html.php",
//     "test" => "_test.html.php",
// ];

//the authentication class is static so there is no need to create an instance of the class
$message = "";
Authentication::protect();

//start buffer
ob_start();
//display admin content
include_once TEMPLATES_DIR . "admin/_adminIndex.html.php";

// Stop output buffering - store output into the $content variable
$content = ob_get_clean();

// Include the main layout template
include_once LAYOUT_TEMPLATES_DIR . "_admin.html.php";
