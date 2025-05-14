<?php if (empty($products)): ?>
    <p>No products.</p>
<?php else: ?>
    <div class="products-container mobile-padding">
        <?php foreach ($products as $product): ?>

            <?php
                $isOnSale = isset($product["salePrice"]) && $product["salePrice"] > 0;
                $price = $isOnSale ? $product["salePrice"] : $product["price"];
                $priceFormatted = sprintf('$%1.2f', $price);
                $originalPriceFormatted = $isOnSale ? sprintf('$%1.2f', $product["price"]) : null;
            ?>

            <article class="product product--list">
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
<?php endif ?>
