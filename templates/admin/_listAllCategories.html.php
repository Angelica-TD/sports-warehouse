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
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td>
                        <a href="edit-category.php?id=<?=$category["categoryId"]?>">
                            <?= htmlspecialchars($category["categoryId"]) ?>
                        </a>
                    </td>
                    <td>
                        <a href="edit-category.php?id=<?=$category["categoryId"]?>">
                            <?= htmlspecialchars($category["categoryName"]) ?>
                        </a>
                    </td>
                    <td>
                        <form method="post" action="delete-category.php">
                            <input type="hidden" name="categoryId" id="categoryId" value="<?=$category["categoryId"]?>">
                            <button type="submit" class="pseudo-icon delete" name="deleteCategory">

                            </button>

                        </form>
                        
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>