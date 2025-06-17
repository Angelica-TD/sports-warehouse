<header class="flex-column gap-smaller">
    <div class="section-wrapper--bgblue section-wrapper--padded">
        <div class="section-constrained">
            <div class="top-nav">

                <nav aria-label="Main site navigation">
                    <input type="checkbox" name="mobile-menu" id="mobile-menu">
                    <label for="mobile-menu">
                        <span id="mobile-menu-icon"><i class="fa-solid fa-bars icon-large"></i> Menu</span>
                        <i id="mobile-menu-icon-close" class="fa-solid fa-xmark icon-large" title="Close mobile menu" aria-hidden="true"></i>
                    </label>

                    <ul class="horizontal-list">
                        <?php if (isset($_SESSION["username"])): ?>
                        <li><a class="login icon-large" href="admin.php">Admin area</a></li>
                        <li><a class="login icon-large" href="logout.php">Logout</a></li>
                        <?php else: ?>
                        <li><a class="login icon-large" href="login.php">Login</a></li>
                        <?php endif ?>
                        <li><a href="index.php">Go to SW website home page</a></li>
                    </ul>
                </nav>

                <div class="account-actions">
                    <ul class="horizontal-list">
                        <?php if (isset($_SESSION["username"])): ?>
                        <li><a class="login icon-large" href="admin.php">Admin area</a></li>
                        <li><a class="login icon-large" href="logout.php">Logout</a></li>
                        <?php else: ?>
                        <li><a class="login icon-large" href="login.php">Login</a></li>
                        <?php endif ?>
                        <li><a class="view-cart icon-large" href="view-cart.php">View Cart</a></li>
                        <li><a class="items-in-cart orange-fill-hover" href="view-cart.php"><?=$itemCount?> items</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <?php if (!isset($_SESSION["username"])): ?>

    <section class="section-constrained site-header flex-column gap-smaller">
        <div class="logo-container">
            <a href="index.php" class="logo-link">
                <h1 class="sr-only">Sports Warehouse</h1>
            </a>
        </div>


    </section>

    <?php endif ?>
    
</header>


