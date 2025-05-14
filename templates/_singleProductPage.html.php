<section class="section-constrained featured-products flex-column gap">
    <?php if (empty($item)): ?>
        <p>No product found</p>
    <?php else: ?>

        <div class="single-product mobile-padding">
            <article class="product">
                <a href="product.php?id=<?= $item["itemId"] ?>">
                    <img class="product__image" src="./assets/images/products/<?= $item["photo"] ?>" alt="<?= htmlspecialchars($item["description"]) ?>">
                </a>

                <div class="product__price <?= $isOnSale ? 'product__price--sale' : '' ?>">
                    <?= $priceFormatted ?>
                    <?php if ($isOnSale): ?>
                        <small>was <del><?= $originalPriceFormatted ?></del></small>
                    <?php endif ?>
                </div>

                <a href="product.php?id=<?= $item["itemId"] ?>">
                    <h3 class="product__name">
                        <?= htmlspecialchars($item["itemName"]) ?>
                    </h3>
                </a>

                <p>
                    <?= htmlspecialchars($item["description"]) ?>
                </p>

            </article>
        </div>

    <?php endif ?>
</section>