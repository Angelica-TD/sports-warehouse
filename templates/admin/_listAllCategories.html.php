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
                        <a class="pseudo-icon delete" href="deleteCategory.php?id=<?=$category["categoryId"]?>">
                            
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>