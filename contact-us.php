<?php

  require_once "includes/common.php";
  require_once "includes/categories.php";
  require_once "includes/helpers.php";

  $success = false;

  // Config
  $title = "Contact us";
  $styles = [
    "contact.css"
  ];

  if (isset($_POST["submitComingSoon"])) {

    // Collection of all errors for this submission (none by default)
    $errors = [];
  
    // Get data passed to this page ($_POST superglobal array)
    $firstName = $_POST["firstName"] ?? "";
    $lastName = $_POST["lastName"] ?? "";
    $email = $_POST["emailAddress"] ?? "";
    $mobile = $_POST["contactNumber"] ?? "";
    $comments = $_POST["comments"] ?? "";
  
    $firstName = trim($firstName);
  
    // Validate first name
    if ($firstName === "") {
      $errors["firstName"] = "First name is required";
    } else if (strlen($firstName) < 2) {
      $errors["firstName"] = "First name must be 2+ characters";
    }
  
    // Validate last name
    if ($lastName === "") {
      $errors["lastName"] = "Last name is required";
    } else if (strlen($lastName) < 2) {
      $errors["lastName"] = "Last name must be 2+ characters";
    }
  
    // Validate email
    if ($email === "") {
      $errors["email"] = "Email is required";
    }
    // Email pattern match
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors["email"] = "Invalid email pattern";
    }
  
    $success = count($errors) === 0 ? true : false;
  
    if ($success) {
      unset($_POST);
    }
  }

  ob_start();

  // Include the page-specific template
  include_once TEMPLATES_DIR . "_contactPage.html.php";

  // Stop output buffering - store output into the $content variable
  $content = ob_get_clean();

  // Include the main layout template
  include_once TEMPLATES_DIR . "_layout.html.php";