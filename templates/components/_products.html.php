<?php if (empty($products)): ?>
    <p>No products.</p>
<?php else: ?>

    <div class="products-container <?= $cartClass ?> mobile-padding">
        <?php foreach ($products as $product): ?>
            <?php
            $isOnSale = isset($product["salePrice"]) && $product["salePrice"] > 0;
            $price = $isOnSale ? $product["salePrice"] : $product["price"];
            $priceFormatted = sprintf('$%1.2f', $price);
            $originalPriceFormatted = $isOnSale ? sprintf('$%1.2f', $product["price"]) : null;
            ?>
            <article class="product product--<?= $displayType ?>">
                <a href="product.php?id=<?= $product["itemId"] ?>">
                    <?php
                    $photo = !empty($product["photo"]) && file_exists("./assets/images/products/{$product["photo"]}")
                        ? $product["photo"]
                        : "placeholder.png";
                    ?>
                    <img class="product__image" src="./assets/images/products/<?= $photo ?>" alt="">
                </a>

                <div class="product__price <?= $isOnSale ? 'product__price--sale' : '' ?>">
                    <?php if ($price > 0): ?>
                    <?= $priceFormatted ?>
                    <?php if ($isOnSale): ?>
                        <small>was <del><?= $originalPriceFormatted ?></del></small>
                    <?php endif ?>
                    <?php endif ?>
                </div>

                <a href="product.php?id=<?= $product["itemId"] ?>">
                    <h3 class="product__name">
                        <?= htmlspecialchars($product["itemName"]) ?>
                    </h3>
                </a>

                <?php if ($price > 0): ?>
                <?php include BLOCK_TEMPLATES_DIR . "_cartButton.html.php"; ?>
                <?php endif ?>

            </article>
        <?php endforeach ?>
    </div>

<?php endif ?>