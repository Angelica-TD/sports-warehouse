<?php foreach ($categories as $category): ?>

<?php 
    // Convert categoryName to a URL-friendly slug (lowercase, spaces replaced by hyphens)
    $categorySlug = urlencode(strtolower(str_replace(' ', '-', $category["categoryName"])));
?>

<li>
    <a href="/products/<?= $categorySlug ?>"><?= $category["categoryName"] ?></a>
</li>
<?php endforeach ?>