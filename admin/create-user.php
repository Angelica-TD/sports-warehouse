<?php
require_once "../includes/common.php";
require_once CLASSES_DIR . "Auth.php";

$title = "Create user";
$pageHeading = "Create new user";
//the authentication class is static so there is no need to create an instance of the class
$message = "";
Authentication::protect();
if(!empty($_POST["username"]) && !empty($_POST["password"]))
{
//add user
$message = Authentication::createUser($_POST["username"], $_POST["password"], $db);
}
//start buffer
ob_start();
//display create user form
include_once TEMPLATES_DIR . "admin/_createUserForm.html.php";
$content = ob_get_clean();
include_once LAYOUT_TEMPLATES_DIR . "_admin.html.php";
?>