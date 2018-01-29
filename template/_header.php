<?php

use Inc\Utils\User;
use Inc\Base\BaseController;
use Inc\Utils\Login;

$baseController = new BaseController();
$login = new Login();
// current User
$user = User::getCurrentUser();

$largeMenuPages = array(
    "admin-area"
);
$smallMenu = true;

if (isset($_GET['name']) && $page = $_GET['name']) {
    if (isset($_GET['category'])) $category = $_GET['category'];

    foreach ($largeMenuPages as $largeMenuPage) {
        if ($page == $largeMenuPage) {
            $smallMenu = false;
        }
    }
}
?>

<html lang="it">
<head>
    <meta charset="utf-8" content="text/html" ;>
    </meta>
    <title>
        Willychok
        <?php
        if (!empty($category)) echo " | " . str_replace('-', ' ', ucfirst($category));
        else if (!empty($page)) echo " | " . str_replace('-', ' ', ucfirst($page));
        ?>
    </title>
    <?php require_once("_head.php"); ?>
</head>
<body>

<header class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <?php if ($smallMenu) echo "<div class='container'>"; ?>
    <div class="cont-logo">
        <a href="<?php echo $baseController->website_url ?>">
            <img class="logo" src="<?php echo $baseController->website_url ?>/assets/img/logo-white.png"
                 alt="WillyChock">
        </a>
    </div>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse"
            data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <div class="wrap-menus ">
            <div class="cont-menu">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a class="nav-link"
                           href="<?php echo $baseController->website_url ?>/page.php?name=shop">
                            Shop
                        </a>
                    </li>
                    <?php if (!$login->isUserLoggedIn()) { ?>
                        <li class="nav-item">
                            <a class="nav-link"
                               href="<?php echo $baseController->website_url ?>/page.php?name=login">
                                Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               href="<?php echo $baseController->website_url ?>/page.php?name=registration">
                                Registration
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <?php
            if ($login->isUserLoggedIn()) {

                $cartItems = \Inc\Utils\Cart::getUserCartItem($user->id);

                ?>

                <!-- CART -->
                <div class="cont-menu-cart nav-item">
                    <span id="id-user-page-cat" style="display: none" data-user-id='<?php echo $user->id ?>'></span>
                    <div class="mc-img" id="btn-dropdown-cart" data-toggle="dropdown" aria-haspopup="true"
                         aria-expanded="true">
                        <img class="profile-image"
                             src="<?php echo $baseController->website_url ?>/assets/img/icon/cart-white.png"
                             alt="Profile image"
                        />
                        <div class="mc-number-item">
                            <?php
                            if ($cartItems) {
                                echo "<span class='badge badge-primary'>" . count($cartItems) . "</span>";
                            }

                            ?>
                        </div>
                    </div>
                    <div class="dropdown-menu dropdown-menu-right mu-dd-content" id="dropdown-cart">
                        <a href="page.php?name=cart" style="text-decoration: none;">

                            <div class="gb_qb"></div>
                            <div class="gb_pb"></div>
                            <div class="cont-dd">
                                <h6 class="dropdown-header">Cart</h6>
                                <div id="append-items-cart">
                                </div>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item di-btn-link" href="page.php?name=cart">See your cart</a>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- ICON USER -->
                <div class="cont-menu-user nav-item dropdown">
                    <div class="mu-info" id="dropdown01" data-toggle="dropdown"
                         aria-haspopup="true" aria-expanded="true">
                        <div class="mu-img menu-icon-circle">
                            <img class="profile-image"
                                 src="<?php echo User::getProfilePic($_SESSION['userName']); ?>" alt="Profile image"/>
                        </div>
                    </div>
                    <div class="dropdown-menu dropdown-menu-right mu-dd-content"
                         aria-labelledby="navbarDropdownMenuLink">
                        <div class="gb_qb"></div>
                        <div class="gb_pb"></div>
                        <a class="dropdown-item-muted text-muted"><?php echo $user->userName; ?></a>
                        <a class="dropdown-item"
                           href="<?php echo $baseController->website_url ?>/page.php?name=user">User</a>
                        <?php if (User::isAdmin()) { ?>
                            <a class="dropdown-item"
                               href="<?php echo $baseController->website_url ?>/page.php?name=admin-area&overview">Admin
                                area</a>
                        <?php } ?>
                        <a class="dropdown-item"
                           href="<?php echo $baseController->website_url ?>/page.php?name=login&logout">Logout</a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php if ($smallMenu) echo "</div>"; ?>
</header>
