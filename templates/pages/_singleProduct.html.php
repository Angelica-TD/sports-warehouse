<section class="section-constrained flex-column gap mobile-padding">
    <?php if (empty($productData)): ?>
        <p>No product found</p>
    <?php else: ?>

        <article class="product product--single">
            
            <img class="product__image--single" src="./assets/images/products/<?= $productData["photo"] ?>" alt="<?= htmlspecialchars($productData["description"]) ?>">
                
            <section class="product">
                <h2 class="product__name product__name--single"><?= htmlspecialchars($productData['productName']) ?></h2>
                
                <div class="product__price <?= $productData['onSale'] ? 'product__price--sale' : '' ?>">
                    <?= $productData['finalPriceFormatted'] ?>
                    <?php if ($productData['onSale']): ?>
                        <small>was <del><?= $productData['originalPriceFormatted'] ?></del></small>
                    <?php endif ?>
                </div>

                <p class="product__description">
                    <?= htmlspecialchars($productData["description"]) ?>
                </p>

            </section>           

        </article>

    <?php endif ?>
</section>