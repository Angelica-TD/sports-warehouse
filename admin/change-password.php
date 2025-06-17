<?php
require_once "../includes/common.php";
require_once CLASSES_DIR . "Auth.php";

//the authentication class is static so there is no need to create an instance of the class
Authentication::protect();

$message = "";

if(isset($_POST["changePassword"])) {

    $errors = [];

    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit;
    }

    $currentPassword = $_POST["currentPassword"] ?? "";
    $newPassword = $_POST["newPassword"] ?? "";
    $newPasswordAgain = $_POST["newPasswordAgain"] ?? "";
    $username = $_SESSION["username"] ?? "";

    if ($currentPassword === "") {
      $errors["currentPassword"] = "This is required";
    } else if (!Authentication::verifyPassword($username, $currentPassword, $db)) {
      $errors["currentPassword"] = "Incorrect password";
    }

    if ($newPassword === "") {
      $errors["newPassword"] = "This is required";
    } else if (strlen($newPassword) < 5) {
      $errors["newPassword"] = "Password must be 5+ characters";
    } else if ($newPassword !== $newPasswordAgain) {
      $errors["newPassword"] = "Passwords do not match";
      $errors["newPasswordAgain"] = "Passwords do not match";
    }

    if ($newPasswordAgain === "") {
      $errors["newPasswordAgain"] = "This is required";
    } else if (strlen($newPasswordAgain) < 5) {
      $errors["newPasswordAgain"] = "Password must be 5+ characters";
    }

    $success = count($errors) === 0 ? true : false;

    if ($success) {
        $message = Authentication::updatePassword($username, $newPassword, $db);
        unset($_POST);
    }

}

$title = "Change password";
$scripts = [
    "validateForm.js"
];

//start buffer
ob_start();
//display create user form
include_once TEMPLATES_DIR . "admin/_changePassword.html.php";
$content = ob_get_clean();
include_once LAYOUT_TEMPLATES_DIR . "_admin.html.php";
?>