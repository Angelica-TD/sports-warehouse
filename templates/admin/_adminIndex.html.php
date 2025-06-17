<div class="section-constrained">
    

    <div class="admin-area">
        <?php include BLOCK_TEMPLATES_DIR . "_adminLeftNav.html.php"; ?>

        <?php if (isset($adminActions[$action])): ?>
            <?php include TEMPLATES_DIR . "admin/" . $adminActions[$action]; ?>
        <?php else: ?>
            <p>Welcome <?= $loginName ?>. Please choose an option from the left menu.</p>
        <?php endif; ?>


    </div>
</div>
