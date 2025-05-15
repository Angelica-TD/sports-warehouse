<?php

require_once 'DBAccess.php';

class ProductAccess
{

  private DBAccess $db;
  private int $itemsPerPage = 1;

  public function __construct(DBAccess $db)
  {
    $this->db = $db;
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
    // Fetch featured products
    $sql = <<<SQL
    SELECT	itemId, itemName, photo, price, salePrice, description
    FROM	  item
    WHERE   featured = 1
    SQL;

    // Prepare the statement
    $stmt = $this->db->prepareStatement($sql);
    return $this->db->executeSQL($stmt);
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
    // Count total products
    $sql = <<<SQL
        SELECT COUNT(*) AS total 
        FROM item 
        WHERE categoryId = :categoryId
    SQL;

    $stmt = $this->db->prepareStatement($sql);
    $stmt->bindValue(":categoryId", $categoryId, PDO::PARAM_INT);
    $totalProducts = $this->db->executeSQLReturnOneValue($stmt);

    // Calculate total pages
    $totalPages = ($totalProducts > 0) ? ceil($totalProducts / $itemsPerPage) : 1;

    // Clamp currentPage to valid range
    $currentPage = max(1, min($currentPage, $totalPages));

    // Calculate offset
    $offset = ($currentPage - 1) * $itemsPerPage;

    // Fetch paginated products
    $sql = <<<SQL
        SELECT itemId, itemName, photo, price, salePrice, description
        FROM item
        WHERE categoryId = :categoryId
        LIMIT :limit OFFSET :offset
    SQL;

    $stmt = $this->db->prepareStatement($sql);
    $stmt->bindValue(":categoryId", $categoryId, PDO::PARAM_INT);
    $stmt->bindValue(":limit", $itemsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);

    $products = $this->db->executeSQL($stmt);

    return [
      'products' => $products,
      'totalProducts' => $totalProducts,
      'totalPages' => $totalPages,
      'currentPage' => $currentPage
    ];
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
    $stmt = $this->db->prepareStatement($sql);
    $stmt->bindValue(":categoryId", $categoryId, PDO::PARAM_INT);
    $categoryName = $this->db->executeSQLReturnOneValue($stmt);

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

    $stmt = $this->db->prepareStatement($sql);
    $stmt->bindValue(":searchTerm", "%{$searchTerm}%", PDO::PARAM_STR);
    $totalProducts = $this->db->executeSQLReturnOneValue($stmt);

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

    $stmt = $this->db->prepareStatement($sql);
    $stmt->bindValue(":searchTerm", "%{$searchTerm}%", PDO::PARAM_STR);
    $stmt->bindValue(":limit", $itemsPerPage, PDO::PARAM_INT);
    $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
    $products = $this->db->executeSQL($stmt);

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
  public function getSingleProductByID(int $itemId): ?array
  {
    try {
      $sql = <<<SQL
                SELECT	itemId, itemName, photo, price, salePrice, description
                FROM    item
                WHERE   itemId = :itemId
                SQL;

      $stmt = $this->db->prepareStatement($sql);
      $stmt->bindValue(":itemId", $itemId, PDO::PARAM_INT);
      $item = $this->db->executeSQLReturnOneRow($stmt);

      if (!$item) {
        return null;
      }

      $isOnSale = isset($item["salePrice"]) && $item["salePrice"] > 0;
      $price = $isOnSale ? $item["salePrice"] : $item["price"];

      $item['priceFormatted'] = sprintf('$%1.2f', $price);
      $item['originalPriceFormatted'] = $isOnSale ? sprintf('$%1.2f', $item["price"]) : null;
      $item['isOnSale'] = $isOnSale;

      return $item;
      
    } catch (PDOException $e) {
      die("Query failed: " . $e->getMessage());
    }
  }
}
