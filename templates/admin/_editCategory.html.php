<div>
    <?php if(empty($categoryName)): ?>
        <p>
            Category not found
        </p>
    <?php else: ?>
    <a href="view-categories.php">
        Back to all categories
    </a>
    <h1>
        <?= $title ?>
    </h1>

    <form action="edit-category.php" class="form form--box needs-validation" method="post" novalidate>
    <p><?= $message ?></p>
    <fieldset>
        <legend><?= $title ?></legend>

        <p>
            Category ID: <?=$categoryID?>
        </p>

        <p>
            <label for="newCategoryName">Category name:</label>
            <input type="text" id="newCategoryName" name="newCategoryName" value="<?=$categoryName?>" required>
            <input type="hidden" id="categoryID" name="categoryID" value="<?=$categoryID?>">
            <?php if (!empty($errors["newCategoryName"])): ?>
                <div class="error-message">
                <?= $errors["newCategoryName"] ?>
                </div>
            <?php endif ?>
        </p>

        <p>
            <input type="submit" name="editCategory" value="Update">
        </p>

    </fieldset>
    
    </form>

    <p>
            <form method="post" action="delete-category.php">
                <input type="hidden" name="categoryId" id="categoryId" value="<?=$categoryID?>">
                <button type="submit" class="pseudo-icon delete" name="deleteCategory">

                </button>

            </form>
        </p>
    <?php endif ?>
</div>


