<table>
    <?php foreach ($products as $product): ?>
        
        <tr>
            
            <td>
                <?= htmlspecialchars($product["itemName"]) ?>
            </td>

            <td>
                x<?= $product["quantity"] ?>
            </td>
            <td>
                <?= sprintf('$%1.2f', $product["totalItemPrice"]) ?>
            </td>

        </tr>
    <?php endforeach ?>

    <tr class="subtotal">

        <td colspan="2">
            Total:
        </td>

        <td>
            <?= sprintf('$%1.2f', $subtotal) ?>
        </td>

    </tr>
</table>
