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

    <form action="change-password.php" class="form form--box needs-validation" method="post" novalidate>
    <p><?= $message ?></p>
    <fieldset>
        <legend><?= $title ?></legend>
        <p>
            <label for="currentPassword">Current password:</label>
            <input type="password" id="currentPassword" name="currentPassword" required>
            <?php if (!empty($errors["currentPassword"])): ?>
                <div class="error-message">
                <?= $errors["currentPassword"] ?>
                </div>
            <?php endif ?>
        </p>
        <p>
            <label for="newPassword">New password:</label>
            <input type="password" id="newPassword" name="newPassword" required>
            <?php if (!empty($errors["newPassword"])): ?>
                <div class="error-message">
                <?= $errors["newPassword"] ?>
                </div>
            <?php endif ?>
        </p>

        <p>
            <label for="newPasswordAgain">Re-type new password:</label>
            <input type="password" id="newPasswordAgain" name="newPasswordAgain" required>

            <?php if (!empty($errors["newPasswordAgain"])): ?>
                <div class="error-message">
                <?= $errors["newPasswordAgain"] ?>
                </div>
            <?php endif ?>
        </p>


        <p>
            <input type="submit" name="changePassword" value="Change password">
        </p>
    </fieldset>
    <?php endif ?>
</form>
</div>


