<nav class="sidebar close">
    <header>
        <div class="image-text">
            <span class="image">
                <img src="../static/images/<?= $_SESSION['logo'] ?>" alt="">
            </span>

            <div class="text logo-text">
                <span class="name"><?= $_SESSION['business_name'] ?></span>
                <span class="profession"><?= $_SESSION['city'] ?></span>
            </div>
        </div>

        <i class='fas fa-chevron-right toggle'></i>
    </header>

    <div class="menu-bar">
        <div class="menu">
            <ul class="menu-links">
                <li class="nav-link">
                    <a href="dashboard.php">
                        <i class="fa-solid fa-house icon"> </i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="client.php">
                        <i class="fa-solid fa-user icon"></i>
                        <span class="text nav-text">Client</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="suppliers.php">
                        <i class="fa-solid fa-truck-field icon"></i>
                        <span class="text nav-text">Fournisseur</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="products.php">
                        <i class="fa-solid fa-boxes-stacked icon"></i>
                        <span class="text nav-text">Produits</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="purchase.php">
                        <i class="fa-solid fa-bag-shopping icon"></i>
                        <span class="text nav-text">Purchase</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="sales.php">
                        <i class="fa-solid fa-coins icon"></i>
                        <span class="text nav-text">Salles</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="settings.php">
                        <i class="fa-solid fa-gear icon"></i>
                        <span class="text nav-text">Settings</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="bottom-content">
            <li class="nav-link">
                <a href="../controller/logout.php">
                    <i class="fa-solid fa-arrow-right-from-bracket fa-rotate-180 icon"></i>
                    <span class="text nav-text">Logout</span>
                </a>
            </li>
        </div>
    </div>
</nav>