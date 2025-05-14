<section class="section-constrained featured-products flex-column gap">
<?php if (empty($products)): ?>
    <p>No products.</p>
<?php else: ?>

    <div class="results-count mobile-padding">
        Showing <?= count($products) ?> out of <?= $totalProducts ?> results for <strong><?= htmlspecialchars($categoryName) ?></strong>
    </div>

    <div class="products-container mobile-padding">
        <?php foreach ($products as $product): ?>
            <?php
                $isOnSale = isset($product["salePrice"]) && $product["salePrice"] > 0;
                $price = $isOnSale ? $product["salePrice"] : $product["price"];
                $priceFormatted = sprintf('$%1.2f', $price);
                $originalPriceFormatted = $isOnSale ? sprintf('$%1.2f', $product["price"]) : null;
            ?>
            <article class="product">
                <a href="product.php?id=<?= $product["itemId"] ?>">
                    <img class="product__image" src="./assets/images/products/<?= $product["photo"] ?>" alt="<?= htmlspecialchars($product["description"]) ?>">
                </a>
                
                <div class="product__price <?= $isOnSale ? 'product__price--sale' : '' ?>">
                    <?= $priceFormatted ?>
                    <?php if ($isOnSale): ?>
                        <small>was <del><?= $originalPriceFormatted ?></del></small>
                    <?php endif ?>
                </div>

                <a href="product.php?id=<?= $product["itemId"] ?>">
                    <h3 class="product__name">
                        <?= htmlspecialchars($product["itemName"]) ?>
                    </h3>
                </a>

            </article>
        <?php endforeach ?>
    </div>

    <?php if ($totalPages > 1): ?>
    <nav class="pagination flex-row gap">
        
        <!-- Previous Link -->
        <a 
            href="products.php?id=<?= $categoryId ?>&page=<?= $currentPage - 1 ?>"
            class="<?= $currentPage > 1 ? 'enabled' : 'disabled' ?>"
            <?= $currentPage <= 1 ? 'tabindex="-1"' : '' ?>
        >
            Previous
        </a>

        <!-- Page Number Links -->
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a 
                href="products.php?id=<?= $categoryId ?>&page=<?= $i ?>" 
                class="<?= $i == $currentPage ? 'active' : '' ?> page-number"
            >
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <!-- Next Link -->
        <a 
            href="products.php?id=<?= $categoryId ?>&page=<?= $currentPage + 1 ?>"
            class="<?= $currentPage < $totalPages ? 'enabled' : 'disabled' ?>"
            <?= $currentPage >= $totalPages ? 'tabindex="-1"' : '' ?>
        >
            Next
        </a>

    </nav>
    <?php endif; ?>


<?php endif ?>
</section>