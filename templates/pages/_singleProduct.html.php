<section class="section-constrained flex-column gap mobile-padding">
    <?php if (empty($productData)): ?>
        <p>No product found</p>
    <?php else: ?>

        <article class="product product--single">

            <?php
            $photo = !empty($productData["photo"]) && file_exists("./assets/images/products/{$productData["photo"]}")
                ? $productData["photo"]
                : "placeholder.png";
            ?>
            <img class="product__image" src="./assets/images/products/<?= $photo ?>" alt="">
                
            <section class="product">
                <h2 class="product__name product__name--single"><?= htmlspecialchars($productData['productName']) ?></h2>
                
                <div class="product__price <?= $productData['onSale'] ? 'product__price--sale' : '' ?>">
                    <?php if ($productData['originalPriceFormatted'] !== '$0.00'): ?>
                    <?= $productData['finalPriceFormatted'] ?>
                    <?php if ($productData['onSale']): ?>
                        <small>was <del><?= $productData['originalPriceFormatted'] ?></del></small>
                    <?php endif ?>
                    <?php endif ?>
                </div>

                <p class="product__description">
                    <?= htmlspecialchars($productData["description"]) ?>
                </p>

                <?php if ($productData['originalPriceFormatted'] !== '$0.00'): ?>
                <?php include BLOCK_TEMPLATES_DIR . "_cartButton.html.php"; ?>
                <?php endif ?>

            </section>           

        </article>

    <?php endif ?>
</section>