<?php

use Inc\Classes\User;

$baseController = new \Inc\Base\BaseController();
$login = new \Inc\Classes\Login();

?>

<html lang="it">
<head>
    <meta charset="utf-8" content="text/html" ;>
    </meta>
    <title>Willychok</title>
    <?php require_once("_head.php"); ?>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="cont-logo">
            <a href="<?php echo $baseController->website_url ?>">
                <img class="logo" src="<?php echo $baseController->website_url ?>/assets/img/logo-white.png" alt="logo">
            </a>
        </div>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse"
                data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="wrap-menus collapse navbar-collapse" id="navbarsExampleDefault">
            <div class="cont-menu">
                <ul class="nav-menu">
                    <li class="nav-item"><a class="nav-link"
                                            href="<?php echo $baseController->website_url ?>/page.php?name=shop">Shop</a>
                    </li>
                    <?php if (!$login->isUserLoggedIn()) { ?>
                        <li class="nav-item"><a class="nav-link"
                                                href="<?php echo $baseController->website_url ?>/page.php?name=login">Login</a>
                        </li>
                        <li class="nav-item"><a class="nav-link"
                                                href="<?php echo $baseController->website_url ?>/page.php?name=registration">Registration</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <?php if ($login->isUserLoggedIn()) { ?>
                <div class="cont-menu-cart nav-item">
                    <div class="mc-img">
                        <img class="profile-image"
                             src="<?php echo $baseController->website_url ?>/assets/img/icon/cart-white.png"/>
                    </div>
                    <div class="mc-number-item">
                        <span class="badge badge-primary">2</span>
                    </div>
                </div>
                <div class="cont-menu-user nav-item dropdown">
                    <div class="mu-info" id="dropdown01" data-toggle="dropdown"
                         aria-haspopup="true" aria-expanded="true">
                        <div class="mu-img menu-icon-circle">
                            <img class="profile-image"
                                 src="<?php echo User::getProfilePic($_SESSION['userName']); ?>"/>
                        </div>
                        <span class="mu-dd-button"><?php echo $_SESSION['userName']; ?></span>
                    </div>
                    <div class="dropdown-menu mu-dd-content " aria-labelledby="dropdown01">
                        <a class="dropdown-item"
                           href="<?php echo $baseController->website_url ?>/page.php?name=user">User</a>
                        <a class="dropdown-item"
                           href="<?php echo $baseController->website_url ?>/page.php?name=login&logout">Logout</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </nav>
</header>
