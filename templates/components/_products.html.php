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

                <form action="products.php" method="post" class="add-to-cart-form">
                    <input type="hidden" name="productId" value="<?= $product["itemId"] ?>">
                    <input type="hidden" id="qty<?= $product["itemId"] ?>" name="quantity" value="1">
                    <input type="hidden" name="returnUrl" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                    <button type="submit" class="add-to-cart-button" name="addToCart" value="addToCart">Add to Cart</button>
                </form>

            </article>
        <?php endforeach ?>
    </div>

<?php endif ?>