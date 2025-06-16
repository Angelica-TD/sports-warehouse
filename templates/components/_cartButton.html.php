<form action="products.php" method="post" class="modify-quantity">

    <div class="num-block">
        <div class="num-in">
            <span class="minus dis"></span>
            <label class="sr-only" for="qty<?= $product["itemId"] ?>">Quantity:</label>
            <input class="quantity in-num" type="text" id="qty<?= $product["itemId"] ?>" name="quantity" value="<?= $product["quantity"] > 1 ? $product["quantity"] : 1 ?>" min="0" max="10" readonly="">
            <span class="plus"></span>
        </div>
    </div>

    <input type="hidden" name="productId" value="<?= $product["itemId"] ?>">
    <input type="hidden" name="returnUrl" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">

    <button type="submit" class="<?= $product["inCart"] ? "update-quantity" : "add-to-cart" ?> pseudo-icon" name="cartAction" value="<?= $product["inCart"] ? "updateItemInCart" : "addToCart" ?>">
        <?= $product["inCart"] ? "Update quantity" : "Add to cart" ?>
    </button>

    <?php if ($cartClass === "cart-page"): ?>
    <button type="submit" class="remove-product" name="cartAction" value="removeProduct">
        <i class="bi bi-trash3-fill"></i>
    </button>
    <?php endif ?>

</form>