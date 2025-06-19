<div>
    <?php if(empty($productInfo["productName"])): ?>
        <p>
            Product not found
        </p>
    <?php else: ?>
    <a href="view-products.php">
        Back to all products
    </a>
    <h1>
        <?= $title ?>
    </h1>

    <form action="edit-product.php" class="form form--box needs-validation" enctype="multipart/form-data" method="post" novalidate>
    <p><?= $message ?></p>
    <fieldset>
        <legend><?= $title ?></legend>

        <p>
            Product ID: <?=$productID?>
        </p>

        <p>
            <img style="max-width: 200px;" src="../assets/images/products/<?=$productInfo["image"]?>" alt="">
        </p>

        <p>
            <label for="productName">Product name:</label>
            <input type="text" id="productName" name="productName" <?= setValue("productName", $productInfo) ?> required>
            <input type="hidden" id="productID" name="productID" value="<?=$productID?>">
            <?php if (!empty($errors["productName"])): ?>
                <div class="error-message">
                <?= $errors["productName"] ?>
                </div>
            <?php endif ?>
        </p>

        <p>
            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['categoryId'] ?>"
                        <?= (isset($productInfo['categoryId']) && $productInfo['categoryId'] == $category['categoryId']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['categoryName']) ?>
                    </option>
                <?php endforeach ?>
            </select>

            <?php if (!empty($errors["category"])): ?>
                <div class="error-message">
                <?= $errors["category"] ?>
                </div>
            <?php endif ?>
        </p>



        <p>

            <label for="productImage">Change image:</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="<?= 100 * 1024 // 100KB ?>" />
            <input type="file" id="productImage" name="productImage" value="">

            <?php if (!empty($errors["productImage"])): ?>
                <div class="error-message">
                <?= $errors["productImage"] ?>
                </div>
            <?php endif ?>

        </p>

        <p>
            <label for="productDescription">Product description:</label>
            <textarea id="productDescription" name="productDescription" placeholder="Description.."><?= getEncodedValue("productDescription", $productInfo) ?></textarea>

            <?php if (!empty($errors["productDescription"])): ?>
                <div class="error-message">
                <?= $errors["productDescription"] ?>
                </div>
            <?php endif ?>
        </p>

        <p>
            <label for="productPrice">Price:</label>
            <input type="number" step="0.01" name="productPrice" id="productPrice" <?= setValue("productPrice", $productInfo) ?> required />
            
            <?php if (!empty($errors["productPrice"])): ?>
                <div class="error-message">
                <?= $errors["productPrice"] ?>
                </div>
            <?php endif ?>
        </p>

        <p>
            <label for="productSalePrice">Sale Price</label>
            <input type="number" step="0.01" name="productSalePrice" id="productSalePrice" <?= setValue("productSalePrice", $productInfo) ?> />
        </p>

        <p>
            <label for="productFeatured">Add as featured product</label>
            <input type="hidden" name="productFeatured" value="0" />
            <input
                type="checkbox"
                id="productFeatured"
                name="productFeatured"
                value="1"
                <?= (($_POST['productFeatured'] ?? $productInfo['featured'] ?? 0) == 1) ? 'checked' : '' ?>
            />
        </p>

        <p>
            <input type="submit" name="editProduct" value="Update">
        </p>

    </fieldset>
    
    </form>

    <p>
            <form method="post" action="delete-product.php">
                <input type="hidden" name="productId" id="productId" value="<?=$productID?>">
                <button type="submit" class="pseudo-icon delete" name="deleteProduct">

                </button>

            </form>
        </p>
    <?php endif ?>

</div>