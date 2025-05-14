<section class="section-constrained flex-column gap mobile-padding">
    <?php if (empty($item)): ?>
        <p>No product found</p>
    <?php else: ?>

        <article class="product product--single">
            
            <img class="product__image--single" src="./assets/images/products/<?= $item["photo"] ?>" alt="<?= htmlspecialchars($item["description"]) ?>">
                
            <section class="product">
                <h2 class="product__name product__name--single"><?= htmlspecialchars($item['itemName']) ?></h2>
                
                <div class="product__price <?= $isOnSale ? 'product__price--sale' : '' ?>">
                    <?= $priceFormatted ?>
                    <?php if ($isOnSale): ?>
                        <small>was <del><?= $originalPriceFormatted ?></del></small>
                    <?php endif ?>
                </div>

                <p class="product__description">
                    <?= htmlspecialchars($item["description"]) ?>
                </p>

            </section>           

        </article>

    <?php endif ?>
</section>