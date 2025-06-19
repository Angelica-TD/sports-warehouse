<div>

    <a href="view-products.php">
        Back to all products
    </a>
    <h1>
        <?= $title ?>
    </h1>

    <?php if(isset($newProductId)): ?>

    <p>
        Product successfully added.
    </p>

    <a href="edit-product.php?id=<?=$newProductId?>">View / edit here</a>

    <p>
        Or add another below:
    </p>

    <?php endif ?>

<form class="form needs-validation" action="add-product.php" method="post" enctype="multipart/form-data" novalidate>
  <fieldset>
    <legend>Product information</legend>


    <p>
        <label for="productName">Product name:</label>
        <input type="text" id="productName" name="productName" value="" required>

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
            <option value="" disabled selected hidden>Select a category</option>
            <option value="<?=$category['categoryId']?>">
                <?=$category['categoryName']?>
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

        <label for="productImage">Product image:</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= 100 * 1024 // 100KB ?>" />
        <input type="file" id="productImage" name="productImage" value="">

    </p>

    <p>
        <label for="productDescription">Product description:</label>
        <textarea id="productDescription" name="productDescription" placeholder="Description.."></textarea>
    </p>

    <p>
        <label for="productPrice">Price:</label>
        <input type="number" step="0.01" name="productPrice" id="productPrice" required />
        
        <?php if (!empty($errors["productPrice"])): ?>
            <div class="error-message">
            <?= $errors["productPrice"] ?>
            </div>
        <?php endif ?>
    </p>

    <p>
        <label for="productSalePrice">Sale Price</label>
        <input type="number" step="0.01" name="productSalePrice" id="productSalePrice" />
    </p>

    <p>
        <label for="productFeatured">Add as featured product</label>
        <input type="hidden" name="productFeatured" value="0" />
        <input type="checkbox" id="productFeatured" name="productFeatured" value="1" />
    </p>

    <p>
        <input type="submit" name="addProduct" value="Add">
    </p>

  </fieldset>

</form>

</div>