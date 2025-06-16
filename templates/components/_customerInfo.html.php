<?php if (!empty($customerInfo)): ?>

    <div class="d-flex">
        <h3>
            Ship to
        </h3>
        <form method="POST" action="checkout.php">
            <button class="edit-info d-flex" type="submit" name="editShippingInfo">Edit</button>
        </form>
    </div>
    
    <div class="customer-info">
        <div class="customer-info--name">
            <?= htmlspecialchars($customerInfo["fullName"]) ?>
        </div>
        
        <div class="customer-info--email">
            <?= htmlspecialchars($customerInfo["emailAddress"]) ?>
        </div>

        <div class="customer-info--mobile">
            <?= htmlspecialchars($customerInfo["contactNumber"]) ?>
        </div>

        <div class="customer-info--street">
            <?= htmlspecialchars($customerInfo["streetAddress"]) ?>
        </div>

        <div class="customer-info--suburb">
            <?= htmlspecialchars($customerInfo["suburb"]) ?> <?= htmlspecialchars($customerInfo["postcode"]) ?>, <?= htmlspecialchars($customerInfo["state"]) ?>
        </div>
    </div>

<?php endif ?>