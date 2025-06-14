<?php

  // Dependencies
  require_once "includes/common.php";
  require_once "includes/helpers.php";

  $productCount = $cart->count();

  if ($productCount <= 0) {
    header("Location: index.php");
    exit;
  }

  $products = $cart->getItemsForDisplay($db);
  $subtotal = $cart->calculateTotal();

  if(isset($_POST["saveShippingInfo"]))
  {

    $errors = [];
  
    $firstName = $_POST["firstName"] ?? "";
    $lastName = $_POST["lastName"] ?? "";
    $mobile = $_POST["contactNumber"] ?? "";
    $email = $_POST["emailAddress"] ?? "";
    $street = $_POST["streetAddress"] ?? "";
    $suburb = $_POST["suburb"] ?? "";
    $postcode = $_POST["postcode"] ?? "";
    $state = $_POST["state"] ?? "";
  
    $firstName = trim($firstName);
  
    if ($firstName === "") {
      $errors["firstName"] = "First name is required";
    } else if (strlen($firstName) < 2) {
      $errors["firstName"] = "First name must be 2+ characters";
    }
  
    if ($lastName === "") {
      $errors["lastName"] = "Last name is required";
    } else if (strlen($lastName) < 2) {
      $errors["lastName"] = "Last name must be 2+ characters";
    }
  
    if ($email === "") {
      $errors["email"] = "Email is required";
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors["email"] = "Invalid email pattern";
    }
  
    $success = count($errors) === 0 ? true : false;
  
    if ($success) {

      $customer = new Customer(
        $firstName,
        $lastName,
        $mobile,
        $email,
        $street,
        $suburb,
        $postcode,
        $state
      );

      $_SESSION["customer"] = $customer;
      $_SESSION["infoSaved"] = true;

      unset($_POST);
    }

  }

  $customerInfo = null;

  if (isset($_SESSION["customer"])) {
    $customer = $_SESSION["customer"];

    $customerInfo = [
      "fullName" => $customer->getFirstName() . " " . $customer->getLastName(),
      "email" => $customer->getEmailAddress(),
      "mobile" => $customer->getContactNumber(),
      "street" => $customer->getStreetAddress(),
      "suburb" => $customer->getSuburb(),
      "postcode" => $customer->getPostcode(),
      "state" => strtoupper($customer->getState()),
    ];
  }

  // Config
  $title = "Checkout";
  $styles = [
    "form.css"
  ];

  $scripts = [
    "validateForm.js"
  ];

  ob_start();

  // Include the page-specific template
  include_once PAGE_TEMPLATES_DIR . "_checkout.html.php";

  // Stop output buffering - store output into the $content variable
  $content = ob_get_clean();

  // Include the main layout template
  include_once LAYOUT_TEMPLATES_DIR . "_main.html.php";