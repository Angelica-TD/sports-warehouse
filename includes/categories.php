<?php

  // TODO: Make categories retrieval class-based (just like products)

  // Define
  $sql = <<<SQL
  SELECT	categoryId, categoryName
  FROM	  category
  SQL;

  // Prepare the statement
  $stmt = $db->prepareStatement($sql);

  // Execute query (get the featured products)
  $categories = $db->executeSQL($stmt);
  $categoryId = null;