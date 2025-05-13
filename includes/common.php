<?php

  // Define constant that points to the root directory of the website, which helps when including files throughout your code when you don't know what the current directory is
  // ROOT_DIR will point to the "sports-warehouse" folder
  // INCLUDES_DIR will point to the "sports-warehouse/includes" folder
  // TEMPLATES_DIR will point to the "sports-warehouse/templates" folder
  // SCRIPTS_DIR will point to the "sports-warehouse/assets/js" folder
  define("ROOT_DIR", __DIR__ . "/../");
  define("INCLUDES_DIR", ROOT_DIR . "includes/");
  define("TEMPLATES_DIR", ROOT_DIR . "templates/");
  define("SCRIPTS_DIR", ROOT_DIR . "assets/js/");
  define("STYLES_DIR", ROOT_DIR . "assets/css/");
  define("IMAGES_DIR", ROOT_DIR . "assets/images/");
  define('COMPANY_NAME', 'Sports Warehouse');


  // Database connection (create DBAccess instance in the $db variable)
  require_once INCLUDES_DIR . "database.php";

  // Open the database connection
  $db->connect();