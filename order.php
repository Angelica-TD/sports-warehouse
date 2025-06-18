<?php
  require_once "includes/common.php";

  $orderID = $_GET["orderID"] ?? 0;

  if($orderID > 0 && isset($_SESSION["customer"])){
    $title = "Order details for: " . $orderID;
  } else if ($orderID === 0){
    header("Location: index.php");
    exit();
  }

  unset($_SESSION["cart"]);
  unset($_SESSION["editInfo"]);

  ob_start();

  // Include the page-specific template
  include_once PAGE_TEMPLATES_DIR . "_thankyou.html.php";

  // Stop output buffering - store output into the $content variable
  $content = ob_get_clean();

  // Include the main layout template
  include_once LAYOUT_TEMPLATES_DIR . "_main.html.php";