<?php

  // Dependencies
  require_once ROOT_DIR . "classes/DBAccess.php";

  // Detect if local environment
  $isLocal = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1', 'localhost']);

  // Set DB credentials
  if ($isLocal) {
    $dbServer   = "localhost";
    $dbDatbase  = "SportsWarehouse";
    $dbUsername = "root";
    $dbPassword = "";
  } else {
    $dbServer   = getenv("DB_SERVER");
    $dbDatbase  = getenv("DB_DATABASE");
    $dbUsername = getenv("DB_USERNAME");
    $dbPassword = getenv("DB_PASSWORD");
  }

  // Error handling
  if (!$isLocal) {
    ini_set('display_errors', 0);
    error_reporting(0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../logs/php-error.log');
  } else {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
  }

  // Initialise DB
  try {
    $db = new DBAccess($dbServer, $dbDatbase, $dbUsername, $dbPassword);
  } catch (PDOException $e) {
    error_log("DB connection failed: " . $e->getMessage());
    die("Database connection error.");
  }
