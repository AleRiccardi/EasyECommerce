<?php

use Inc\Utils\User;
use Inc\Base\BaseController;
use Inc\Utils\Login;

$baseController = new BaseController();
$login = new Login();
// current User
$user = User::getCurrentUser();
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

            <?php if ($login->isUserLoggedIn()) { ?>

                <!-- CART -->
                <div class="cont-menu-cart nav-item">
                    <span id="id-user-page-cat" style="display: none" data-user-id='<?php echo $user->id ?>'></span>
                    <div class="mc-img" id="btn-dropdown-cart" data-toggle="dropdown" aria-haspopup="true"
                         aria-expanded="true">
                        <img class="profile-image"
                             src="<?php echo $baseController->website_url ?>/assets/img/icon/cart-white.png"/>
                        <div class="mc-number-item">
                        </div>
                    </div>
                    <div class="dropdown-menu dropdown-menu-right mu-dd-content" id="dropdown-cart">
                        <div class="gb_qb"></div>
                        <div class="gb_pb"></div>
                        <div class="cont-dd">
                            <h6 class="dropdown-header">Cart</h6>

                            <div class="dropdown-item card-item-cont">
                                <div class="middle-h-cont mhc-height-max">
                                    <div class="card-item-img-cont middle-h-item">
                                        <div class="middle-h-cont">
                                            <img id="card-item-img" class="card-item-img middle-h-item"
                                                 src="http://localhost:8888/willychock/assets/uploads/2018/Boston-Cream-Donut.jpg"
                                                 alt="Card image cap">
                                        </div>
                                    </div>
                                    <span class="middle-h-item card-item-title" id="card-item-title">KitKattttttttt</span>
                                    &nbsp;
                                    <span class="badge badge-secondary ml-auto middle-h-item" id="card-item-quantity">2</span>
                                </div>
                            </div>

                            <div class="dropdown-divider"></div>
                            <div class="dropdown-item di-btn-link" href="">See your cart</div>
                        </div>
                    </div>
                </div>

                <!-- ICON USER -->
                <div class="cont-menu-user nav-item dropdown">
                    <div class="mu-info" id="dropdown01" data-toggle="dropdown"
                         aria-haspopup="true" aria-expanded="true">
                        <div class="mu-img menu-icon-circle">
                            <img class="profile-image"
                                 src="<?php echo User::getProfilePic($_SESSION['userName']); ?>"/>
                        </div>
                    </div>
                    <div class="dropdown-menu dropdown-menu-right mu-dd-content"
                         aria-labelledby="navbarDropdownMenuLink">
                        <div class="gb_qb"></div>
                        <div class="gb_pb"></div>
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
            <?php } ?>
        </div>
    </nav>
</header>
