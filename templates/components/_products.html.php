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
                    <img class="product__image" src="./assets/images/products/<?= $product["photo"] ?>" alt="">
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

                <form action="products.php" method="post" class="modify-quantity">

                    <div class="num-block">
                        <div class="num-in">
                            <span class="minus dis"></span>
                            <label class="sr-only" for="qty<?= $product["itemId"] ?>">Quantity:</label>
                            <input class="quantity in-num" type="text" id="qty<?= $product["itemId"] ?>" name="quantity" value="<?= $product["quantity"] > 1 ? $product["quantity"] : 1 ?>" min="1" max="10" readonly="">
                            <span class="plus"></span>
                        </div>
                    </div>

                    <input type="hidden" name="productId" value="<?= $product["itemId"] ?>">
                    <input type="hidden" name="returnUrl" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">

                    <button type="submit" class="<?= $product["inCart"] ? "update-quantity" : "add-to-cart" ?> pseudo-icon" name="cartAction" value="<?= $product["inCart"] ? "updateItemInCart" : "addToCart" ?>">
                        <?= $product["inCart"] ? "Update" : "Add to cart" ?>
                    </button>

                    <?php if ($cartClass === "cart-page"): ?>
                    <button type="submit" class="remove-product" name="cartAction" value="removeProduct">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                    <?php endif ?>

                </form>


            </article>
        <?php endforeach ?>
    </div>

<?php endif ?>