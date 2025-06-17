<footer class="flex-column gap">

    <div class="section-constrained copyright">
        <p>&copy; Copyright 2025 Sports Warehouse.</p>
        <p>All rights reserved.</p>
        <p>Website made by Angie.</p>
    </div>
</footer>



<!-- <script src="https://cdn.botpress.cloud/webchat/v2.2/inject.js"></script>
<script src="https://files.bpcontent.cloud/2024/12/03/08/20241203082132-69RIF0T4.js"></script> -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<?php
// Normalise scripts to array
$scripts = isset($scripts)
    ? (is_array($scripts) ? $scripts : [$scripts])
    : [];

foreach ($scripts as $src) :
?>
    <script src="../assets/js/<?= htmlspecialchars($src) ?>"></script>
<?php endforeach; ?>