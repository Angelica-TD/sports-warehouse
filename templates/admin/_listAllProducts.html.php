<div>
    <h1>
        <?= $title ?>
    </h1>
    <table class="bordered edit-categories">
        <thead>
            <tr>
                <td>
                    ID
                </td>
                <td>
                    Name
                </td>
                <td>
                    Delete
                </td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td>
                        <a href="edit-product.php?id=<?=$product["itemId"]?>">
                            <?= htmlspecialchars($product["itemId"]) ?>
                        </a>
                    </td>
                    <td>
                        <a href="edit-product.php?id=<?=$product["itemId"]?>">
                            <?= htmlspecialchars($product["itemName"]) ?>
                        </a>
                    </td>
                    <td>
                        <form method="post" action="delete-product.php">
                            <input type="hidden" name="productId" id="productId" value="<?=$product["itemId"]?>">
                            <button type="submit" class="pseudo-icon delete" name="deleteProduct">

                            </button>

                        </form>
                        
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <?php include BLOCK_TEMPLATES_DIR . "_pagination.html.php"; ?>
</div>