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

  $_SESSION["editInfo"] = false;

  if(isset($_POST["editShippingInfo"])){
    $_SESSION["editInfo"] = true;
  }

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
      $_SESSION["editInfo"] = false;

      unset($_POST);
    }

  }

  $customerInfo = [];

  if (isset($_SESSION["customer"])) {
    $customer = $_SESSION["customer"];

    $customerInfo = [
      "firstName" => $customer->getFirstName(),
      "lastName" => $customer->getLastName(),
      "fullName" => $customer->getFirstName() . " " . $customer->getLastName(),
      "emailAddress" => $customer->getEmailAddress(),
      "contactNumber" => $customer->getContactNumber(),
      "streetAddress" => $customer->getStreetAddress(),
      "suburb" => $customer->getSuburb(),
      "postcode" => $customer->getPostcode(),
      "state" => strtoupper($customer->getState()),
    ];
  }

  if(isset($_SESSION["infoSaved"]) && isset($_POST["placeOrder"])){

    $errors = [];

    $name = $customerInfo["firstName"] . " " . $customerInfo["lastName"];
    $address = $customerInfo["streetAddress"] . " " . $customerInfo["suburb"] . " " . $customerInfo["postcode"] . " " . $customerInfo["state"];

    $nameOnCard = $_POST["cardName"] ?? "";
    $cardNumber = preg_replace('/\D/', "", $_POST["cardNumber"] ?? "");
    $expiryMonth = $_POST["expiryMonth"] ?? "";
    $expiryYear = $_POST["expiryYear"] ?? "";
    $cvv = $_POST["cvv"] ?? "";

    if ($nameOnCard === "") {
      $errors["cardName"] = "Name is required";
    } else if (strlen($nameOnCard) < 2) {
      $errors["cardName"] = "Name must be 2+ characters";
    }

    if ($cardNumber === "") {
      $errors["cardNumber"] = "This is required.";
    } else if (strlen($cardNumber) > 19) {
      $errors["cardNumber"] = "Invalid";
    }

    if ($expiryMonth === "") {
      $errors["expiryMonth"] = "This is required.";
    } else if (!ctype_digit($expiryMonth) || (int)$expiryMonth < 1 || (int)$expiryMonth > 12) {
      $errors["expiryMonth"] = "Invalid month.";
    }

    if ($expiryYear === "") {
      $errors["expiryYear"] = "Expiry year is required.";
    } else if (!ctype_digit($expiryYear)) {
      $errors["expiryYear"] = "Invalid year.";
    }

    if (!isset($errors["expiryMonth"]) && !isset($errors["expiryYear"])) {
      $currentYear = (int)date("Y");
      $currentMonth = (int)date("n");

      $expYear = (int)$expiryYear;
      $expMonth = (int)$expiryMonth;

      if ($expYear < $currentYear || ($expYear === $currentYear && $expMonth <= $currentMonth)) {
          $errors["expiryMonth"] = "Card has expired.";
          $errors["expiryYear"] = "Card has expired.";
      }
    }

    if ($cvv === "") {
      $errors["cvv"] = "This is required.";
    } else if (strlen($cvv) > 4) {
      $errors["cvv"] = "Invalid";
    }

    $success = count($errors) === 0 ? true : false;

    if ($success) {

      $orderID = $cart->saveOrder($db, $name, $address, $customerInfo["emailAddress"], $customerInfo["contactNumber"], $nameOnCard, $cardNumber, $expiryMonth, $expiryYear, $cvv);

      unset($_POST);

      header("Location: order.php?orderID=" . urlencode($orderID));
      exit();

    }

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