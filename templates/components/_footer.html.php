<footer class="flex-column gap">
    <div class="section-wrapper section-wrapper--bgblue">
        <div class="section-constrained footer-nav">
            <section class="site-nav" aria-labelledby="site-nav-heading">
                <h2 id="site-nav-heading">Site navigation</h2>
                <nav aria-label="Footer navigation">
                    <ul class="left-pill">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About SW</a></li>
                        <li><a href="contact-us.php">Contact us</a></li>
                        <li><a href="#">View products</a></li>
                        <li><a href="#">Privacy policy</a></li>
                    </ul>
                </nav>
            </section>
            <section class="product-categories" aria-labelledby="product-categories-heading">
                <h2 id="product-categories-heading">Product categories</h2>
                <ul class="left-pill">
                    <?php include "_categoriesList.html.php"; ?>
                </ul>
            </section>

            <section class="contact-info" aria-labelledby="contact-sw-heading">
                <h2 id="contact-sw-heading">Contact Sports Warehouse</h2>
                <div class="socials">
                    <a href="#">
                        <img src="./assets/images/socials/facebook.png" alt="Like us on Facebook">
                        <h3>Facebook</h3>
                    </a>
                    <a href="#">
                        <img src="./assets/images/socials/twitter.png" alt="Follow us on Twitter">
                        <h3>Twitter</h3>
                    </a>
                    <a href="#">
                        <img src="./assets/images/socials/other.png" alt="Follow us on other platform">
                        <h3>Other</h3>
                    </a>
                </div>
            </section>

        </div>
    </div>
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
    <script src="./assets/js/<?= htmlspecialchars($src) ?>"></script>
<?php endforeach; ?>