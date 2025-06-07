<?php

require_once 'DBAccess.php';

class Product
{

  private $_productName;
  private $_productID;
  private $_originalPrice;
  private $_photo;
  private $_description;
  private $_salePrice;
  private $_activeProductCategory;
  private DBAccess $_db;

  public function __construct(DBAccess $db)
  {
    $this->_db = $db;
    $this->_activeProductCategory = null;
  }

  // getters

  public function getProductID(): int { return $this->_productID; }
  public function getProductName(): string { return $this->_productName; }
  public function getOriginalPrice(): float { return $this->_originalPrice; }
  public function getSalePrice(): float { return $this->_salePrice; }
  
  public function getFinalPrice(): float 
  { 
    // if there is a salePrice, return that, otherwise return original price
    return $this->hasValidSalePrice() ? $this->_salePrice : $this->_originalPrice;
  }

  public function getOriginalPriceFormatted(): string
  {
      return sprintf('$%1.2f', $this->_originalPrice);
  }

  public function getSalePriceFormatted(): ?string
  {
      return $this->hasValidSalePrice()
        ? sprintf('$%1.2f', $this->_salePrice)
        : null;
  }

  public function getFinalPriceFormatted(): string
  {
      return sprintf('$%1.2f', $this->getFinalPrice());
  }

  /**
   * Get featured products
   * 
   * @param int $categoryId The category ID to fetch products for
   * @param int $currentPage The current page number (1-based)
   * @return array featured products
   * }
   */
  public function getFeaturedProducts(): array
  {
    $this->_db->connect();
    // Fetch featured products
    $sql = <<<SQL
    SELECT	itemId, itemName, photo, price, salePrice, description
    FROM	  item
    WHERE   featured = 1
    SQL;

    // Prepare the statement
    $stmt = $this->_db->prepareStatement($sql);
    return $this->_db->executeSQL($stmt);
  }

  /**
   * Get products for a category with pagination.
   * 
   * @param int $categoryId The category ID to fetch products for
   * @param int $currentPage The current page number (1-based)
   * @param int $itemsPerPage Number of products per page
   * @return array{
   *     products: array,
   *     totalProducts: int,
   *     totalPages: int,
   *     currentPage: int
   * }
   */
  public function getProductsByCategory(int $categoryId, int $currentPage = 1, int $itemsPerPage = 10): array
  {
    $this->_activeProductCategory = $categoryId;
    return $this->getPaginatedProducts($categoryId, $currentPage, $itemsPerPage);
  }

  /**
   * Get the category name by ID
   *
   * @param int $categoryId
   * @return string|null Returns category name or null if not found
   */
  public function getCategoryName(int $categoryId): ?string
  {
    $sql = <<<SQL
            SELECT categoryName 
            FROM category 
            WHERE categoryId = :categoryId
            SQL;
    $stmt = $this->_db->prepareStatement($sql);
    $stmt->bindValue(":categoryId", $categoryId, PDO::PARAM_INT);
    $categoryName = $this->_db->executeSQLReturnOneValue($stmt);

    return $categoryName ?: null;
  }

  /**
   * Get products based on search term (with pagination)
   *
   * @param string $searchTerm
   * @param int $currentPage
   * @param int $itemsPerPage
   * @return array Resultset data (rows)
   */
  public function getProductsBySearchTerm(string $searchTerm, int $currentPage = 1, int $itemsPerPage = 10): array
  {
    // Count total products
    $sql = <<<SQL
          SELECT COUNT(*) AS total
          FROM item
          WHERE itemName LIKE :searchTerm
          OR description LIKE :searchTerm
      SQL;

    $stmt = $this->_db->prepareStatement($sql);
    $stmt->bindValue(":searchTerm", "%{$searchTerm}%", PDO::PARAM_STR);
    $totalProducts = $this->_db->executeSQLReturnOneValue($stmt);

    // Calculate total pages
    $totalPages = ($totalProducts > 0) ? ceil($totalProducts / $itemsPerPage) : 1;
    $currentPage = max(1, min($currentPage, $totalPages));
    $offset = ($currentPage - 1) * $itemsPerPage;

    // Fetch paginated results
    $sql = <<<SQL
          SELECT itemId, itemName, photo, price, salePrice, description
          FROM item
          WHERE itemName LIKE :searchTerm
          OR description LIKE :searchTerm
          LIMIT :limit OFFSET :offset
      SQL;

    $stmt = $this->_db->prepareStatement($sql);
    $stmt->bindValue(":searchTerm", "%{$searchTerm}%", PDO::PARAM_STR);
    $stmt->bindValue(":limit", $itemsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
    $products = $this->_db->executeSQL($stmt);

    return [
      'products' => $products,
      'totalProducts' => $totalProducts,
      'totalPages' => $totalPages,
      'currentPage' => $currentPage
    ];
  }

  /**
   * Get a single product by ID
   *
   * @param int $itemId
   * @return array Resultset data (1 row)
   */
  public function loadSingleProductByID(int $itemId)
  {
    $this->_db->connect();
    try {
      $sql = <<<SQL
                SELECT	itemId, itemName, photo, price, salePrice, description
                FROM    item
                WHERE   itemId = :itemId
                SQL;

      $stmt = $this->_db->prepareStatement($sql);
      $stmt->bindValue(":itemId", $itemId, PDO::PARAM_INT);
      $item = $this->_db->executeSQLReturnOneRow($stmt);

      //populate the private properties with the retrieved values
      $this->_productID = $item["itemId"];
      $this->_productName = $item["itemName"];
      $this->_photo = $item["photo"];
      $this->_originalPrice = $item["price"];
      $this->_salePrice = isset($item["salePrice"]) ? (float) $item["salePrice"] : null;
      $this->_description = $item["description"];
      
    } catch (PDOException $e) {
      throw $e;
    }
  }

  public function getProductData(): ?array
  {

    // check if a product has been loaded
    if (!$this->_productID) {
        return null;
    }

    // return product data for display
    return [
      'productID' => $this->_productID,
      'productName' => $this->_productName,
      'photo' => $this->_photo,
      'originalPriceFormatted' => $this->getOriginalPriceFormatted(),
      'salePriceFormatted' => $this->getSalePriceFormatted(),
      'finalPriceFormatted' => $this->getFinalPriceFormatted(),
      'description' => $this->_description,
      'onSale' => $this->hasValidSalePrice(),
    ];

  }

  public function getAllProducts(int $currentPage = 1, int $itemsPerPage = 10): array
  {
    return $this->getPaginatedProducts(null, $currentPage, $itemsPerPage);
  }

  public function getAllProductCategories()
  {
    $this->_db->connect();
      // Define
    $sql = <<<SQL
    SELECT	categoryId, categoryName
    FROM	  category
    SQL;

    // Prepare the statement
    $stmt = $this->_db->prepareStatement($sql);

    // Execute query (get the featured products)
    return $this->_db->executeSQL($stmt);
    // $categoryId = null;

  }

  public function getActiveProductCategory() : ?int { return $this->_activeProductCategory; }
  
  // private methods

  private function hasValidSalePrice(): bool
  {
      return isset($this->_salePrice) && $this->_salePrice > 0;
  }

  private function getPaginatedProducts(?int $categoryId, int $currentPage, int $itemsPerPage): array
  {
    // $this->_db->connect();

    $totalProducts = $this->countProducts($categoryId);
    $totalPages = max(1, ceil($totalProducts / $itemsPerPage));
    $currentPage = max(1, min($currentPage, $totalPages));
    $offset = ($currentPage - 1) * $itemsPerPage;

    $sql = <<<SQL
        SELECT itemId, itemName, photo, price, salePrice, description
        FROM item
        SQL;

    if ($categoryId) {
        $sql .= " WHERE categoryId = :categoryId";
    }

    $sql .= " LIMIT :limit OFFSET :offset";

    $stmt = $this->_db->prepareStatement($sql);

    if ($categoryId) {
        $stmt->bindValue(":categoryId", $categoryId, PDO::PARAM_INT);
    }

    $stmt->bindValue(":limit", $itemsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);

    $products = $this->_db->executeSQL($stmt);

    return [
        'products' => $products,
        'totalProducts' => $totalProducts,
        'totalPages' => $totalPages,
        'currentPage' => $currentPage
    ];

  }

  private function countProducts(?int $categoryId = null): int
  {

    if ($categoryId) {

      $sql = <<<SQL
          SELECT COUNT(*) AS total 
          FROM item 
          WHERE categoryId = :categoryId
      SQL;

      $stmt = $this->_db->prepareStatement($sql);
      $stmt->bindValue(":categoryId", $categoryId, PDO::PARAM_INT);
    
    } else {

      $sql = <<<SQL
          SELECT COUNT(*) AS total 
          FROM item
      SQL;

      $stmt = $this->_db->prepareStatement($sql);
    
    }

    return $this->_db->executeSQLReturnOneValue($stmt);

  }

}
