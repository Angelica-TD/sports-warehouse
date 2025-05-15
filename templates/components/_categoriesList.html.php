<?php foreach ($categories as $category): ?>

<?php 
    // Convert categoryName to a URL-friendly slug (lowercase, spaces replaced by hyphens)
    $categorySlug = urlencode(strtolower(str_replace(' ', '-', $category["categoryName"])));
?>

<li>
    <a
     href="products.php?id=<?= $category["categoryId"] ?>"
     <?= ($category['categoryId'] == $categoryId) ? "class='active'" : "" ?>>
        <?= $category["categoryName"] ?>
    </a>
</li>
<?php endforeach ?>