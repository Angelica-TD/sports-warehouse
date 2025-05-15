<section class="section-constrained featured-products flex-column gap">
<?php if (empty($products)): ?>
    <p>No products.</p>
<?php else: ?>

    <?php if (empty($searchTerm)): ?>

    <h2 class="strip strip--mobile">
        <?= htmlspecialchars($categoryName) ?>
    </h2>

    <?php endif ?>

    <div class="results-count mobile-padding">
        Showing <?= count($products) ?> out of <?= $totalProducts ?> results 
        <?php if (!empty($searchTerm)): ?>
            for <strong>"<?= htmlspecialchars($searchTerm) ?>"</strong>
        </strong>

        <?php endif ?>
        
        
    </div>

    <?php
        include "_productsList.html.php";
    ?>

    <?php include "_pagination.html.php"; ?>


<?php endif ?>
</section>