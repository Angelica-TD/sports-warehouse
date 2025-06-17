<?php
require_once "includes/common.php";
require_once "classes/Auth.php";

$title = "Login";

$scripts = [
    "validateForm.js"
];
//the authentication class is static so there is no need to create an instance of the class
$message = "";
if (isset($_POST["loginSubmit"])) {
    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        //authenticate user
        $loginSuccess = Authentication::login($_POST["username"], $_POST["password"], $db);
        if (!$loginSuccess) {
            $message = "Username or password incorrect";
            $error = true;
        }
    }
}
//start buffer
ob_start();
// Include the page-specific template
include_once BLOCK_TEMPLATES_DIR . "_loginForm.html.php";

// Stop output buffering - store output into the $content variable
$content = ob_get_clean();

// Include the main layout template
include_once LAYOUT_TEMPLATES_DIR . "_main.html.php";
