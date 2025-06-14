<?php if (!empty($customerInfo)): ?>
<div class="customer-info">
    <div class="customer-info--name">
        <?= htmlspecialchars($customerInfo["fullName"]) ?>
    </div>
    
    <div class="customer-info--email">
        <?= htmlspecialchars($customerInfo["email"]) ?>
    </div>

    <div class="customer-info--mobile">
        <?= htmlspecialchars($customerInfo["mobile"]) ?>
    </div>

    <div class="customer-info--street">
        <?= htmlspecialchars($customerInfo["street"]) ?>
    </div>

    <div class="customer-info--suburb">
        <?= htmlspecialchars($customerInfo["suburb"]) ?> <?= htmlspecialchars($customerInfo["postcode"]) ?>, <?= htmlspecialchars($customerInfo["state"]) ?>
    </div>
</div>
<?php endif ?>