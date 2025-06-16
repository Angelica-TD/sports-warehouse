<form id="checkoutForm" class="form form--checkout needs-validation" action="checkout.php" method="post" novalidate>

    <?php if (!isset($_SESSION['infoSaved']) || (isset($_SESSION['editInfo']) && $_SESSION['editInfo'])): ?>

    <fieldset>
        <legend>
            Shipping information
        </legend>

        <div class="input-group">
            <div class="input-container">
                <input class="floating" type="text" id="firstName" name="firstName" placeholder="" required value="<?= htmlspecialchars($customerInfo["firstName"]) ?>">
                <label class="ud-label" for="firstName">First name</label>

                <?php if (!empty($errors["firstName"])): ?>
                    <div class="error-message">
                    <?= $errors["firstName"] ?>
                    </div>
                <?php endif ?>

            </div>
            <div class="input-container">
                <input class="floating" type="text" id="lastName" name="lastName" placeholder="" required <?= htmlspecialchars($customerInfo["lastName"]) ?>>
                <label class="ud-label" for="lastName">Last name</label>

                <?php if (!empty($errors["lastName"])): ?>
                    <div class="error-message">
                    <?= $errors["lastName"] ?>
                    </div>
                <?php endif ?>

            </div>
        </div>

        <div class="input-group">
            <div class="input-container">
                <input class="floating" type="tel" name="contactNumber" id="contactNumber" placeholder="" <?= htmlspecialchars($customerInfo["mobile"]) ?>>
                <label class="ud-label" for="contactNumber">Contact number</label>
            </div>

            <div class="input-container">
                <input class="floating" type="email" name="emailAddress" id="emailAddress" placeholder="" required <?= htmlspecialchars($customerInfo["email"]) ?>>
                <label class="ud-label" for="emailAddress">Email address</label>

                <?php if (!empty($errors["email"])): ?>
                    <div class="error-message">
                    <?= $errors["email"] ?>
                    </div>
                <?php endif ?>

            </div>
        </div>

        <div class="input-single">

            <div class="input-container">
                <input class="floating" type="text" id="streetAddress" name="streetAddress" placeholder="" required <?= htmlspecialchars($customerInfo["street"]) ?>>
                <label class="ud-label" for="streetAddress">Street address</label>

                <?php if (!empty($errors["streetAddress"])): ?>
                    <div class="error-message">
                    <?= $errors["streetAddress"] ?>
                    </div>
                <?php endif ?>

            </div>

        </div>

        <div class="input-group">
            
            <div class="input-container">
                <input class="floating" type="text" id="suburb" name="suburb" placeholder="" required <?= htmlspecialchars($customerInfo["suburb"]) ?>>
                <label class="ud-label" for="suburb">Suburb</label>

                <?php if (!empty($errors["suburb"])): ?>
                    <div class="error-message">
                    <?= $errors["suburb"] ?>
                    </div>
                <?php endif ?>

            </div>

            <div class="input-container">
                <input class="floating" type="text" id="postcode" name="postcode" placeholder="" required <?= htmlspecialchars($customerInfo["postcode"]) ?>>
                <label class="ud-label" for="postcode">Postcode</label>

                <?php if (!empty($errors["postcode"])): ?>
                    <div class="error-message">
                    <?= $errors["postcode"] ?>
                    </div>
                <?php endif ?>

            </div>

            <div class="input-container">

                <label class="sr-only" for="state">State</label>

                <select name="state" id="state" class="has-placeholder floating" required>
                    <option value="" disabled selected hidden>State</option>
                    <option <?= setSelected("state", "nsw") ?> value="nsw">nsw</option>
                    <option <?= setSelected("state", "qld") ?> value="qld">qld</option>
                    <option <?= setSelected("state", "vic") ?> value="vic">vic</option>
                    <option <?= setSelected("state", "wa") ?> value="wa">wa</option>
                    <option <?= setSelected("state", "tas") ?> value="tas">tas</option>
                    <option <?= setSelected("state", "sa") ?> value="sa">sa</option>
                </select>

                <?php if (!empty($errors["state"])): ?>
                    <div class="error-message">
                    <?= $errors["state"] ?>
                    </div>
                <?php endif ?>

            </div>


        </div>

        <?php if (!isset($_SESSION['infoSaved'])): ?>
        <button type="submit" name="saveShippingInfo" class="btn btn--darkblue">
            Proceed to payment
        </button>
        <?php endif ?>

    </fieldset>

    <?php else: ?>
    <fieldset>
        <legend>
            Payment information
        </legend>

        <div class="input-single">

            <div class="input-container">
                <input class="floating" type="text" id="cardName" name="cardName" placeholder="" required <?= setValue("cardName") ?>>
                <label class="ud-label" for="cardName">Name on card</label>

                <?php if (!empty($errors["cardName"])): ?>
                    <div class="error-message">
                    <?= $errors["cardName"] ?>
                    </div>
                <?php endif ?>

            </div>

        </div>

        <div class="input-single">

            <div class="input-container">
                <input class="floating" type="text" id="cardNumber" name="cardNumber" placeholder="" required <?= setValue("cardNumber") ?>>
                <label class="ud-label" for="cardNumber">Credit card number</label>

                <?php if (!empty($errors["cardNumber"])): ?>
                    <div class="error-message">
                    <?= $errors["cardNumber"] ?>
                    </div>
                <?php endif ?>

            </div>

        </div>

        <div class="input-group">

            <div class="input-container">

                <select id="expiryMonth" name="expiryMonth" class="has-placeholder floating" required>
                    <option value="" disabled selected hidden>MM</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= sprintf('%02d', $i) ?>"><?= sprintf('%02d', $i) ?></option>
                    <?php endfor; ?>
                </select>

                <label class="sr-only" for="expiryMonth">Expiry Month</label>

                <?php if (!empty($errors["expiryMonth"])): ?>
                    <div class="error-message">
                    <?= $errors["expiryMonth"] ?>
                    </div>
                <?php endif ?>

            </div>

            <div class="input-container">
                
                <select id="expiryYear" name="expiryYear" class="has-placeholder floating" required>
                    <option value="" disabled selected hidden>YYYY</option>
                    <?php for ($year = date('Y'); $year <= date('Y') + 10; $year++): ?>
                        <option value="<?= $year ?>"><?= $year ?></option>
                    <?php endfor; ?>
                </select>

                <label class="sr-only" for="expiryYear">Expiry Month</label>

                <?php if (!empty($errors["expiryYear"])): ?>
                    <div class="error-message">
                    <?= $errors["expiryYear"] ?>
                    </div>
                <?php endif ?>

            </div>

            <div class="input-container">
                
                <input class="floating" type="text" id="cvv" name="cvv" maxlength="4" placeholder="" required>
                <label class="ud-label" for="cvv">CVV</label>

                <?php if (!empty($errors["cvv"])): ?>
                    <div class="error-message">
                    <?= $errors["cvv"] ?>
                    </div>
                <?php endif ?>

            </div>
        </div>

        <button type="submit" name="saveShippingInfo" class="btn btn--darkblue">
            Proceed to payment
        </button>

    </fieldset>
    <?php endif ?>

</form>