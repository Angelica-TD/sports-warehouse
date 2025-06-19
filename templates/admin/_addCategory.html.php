<div>

    <a href="view-categories.php">
        Back to all categories
    </a>
    <h1>
        <?= $title ?>
    </h1>

    <?php if(isset($newCategoryId)): ?>

    <p>
        Category successfully added.
    </p>

    <a href="edit-category.php?id=<?=$newCategoryId?>">View / edit here</a>

    <p>
        Or add another below:
    </p>

    <?php endif ?>

    <form action="add-category.php" class="form form--box needs-validation" method="post" novalidate>
    <p><?= $message ?></p>
    <fieldset>
        <legend><?= $title ?></legend>

        <p>
            <label for="newCategoryName">Category name:</label>
            <input type="text" id="newCategoryName" name="newCategoryName" value="" required>

            <?php if (!empty($errors["newCategoryName"])): ?>
                <div class="error-message">
                <?= $errors["newCategoryName"] ?>
                </div>
            <?php endif ?>
        </p>

        <p>
            <input type="submit" name="addCategory" value="Add">
        </p>
    </fieldset>
    </form>

</div>


