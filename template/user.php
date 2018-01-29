<?php

use Inc\Utils\User;

require_once($baseController->website_path . "/template/_header.php");

$user = User::getBy($_SESSION['userName'], "username");

?>
<div class="page fit-height-section">

    <div class="jumbotron user-header">
        <div class="container">
            <div class="user-img-name middle-h-cont">
                <div class="pu-img">
                    <img id="preview-icon" class="profile-image"
                         src="<?php echo User::getProfilePic($_SESSION['userName']); ?>" alt="Profile image" />
                </div>
                <div class="middle-h-item user-name">
                    <h1 class=""><?php echo $user->userName; ?></h1>
                    <span>Registered the <?php echo date("d M Y", strtotime($user->dateRegistration)); ?></span>
                </div>
            </div>
        </div>
    </div>
    <section class="user-body">
        <div class="container">
            <!-- Example row of columns -->
            <div class="row flex-container justify-content-center">
                <div class="user-action flex-item col-8 col-sm-6 col-md-3">
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=cart">
                        <div class="icon-action">
                            <img src="<?php echo $baseController->website_url ?>/assets/img/icon/cart.png" alt="Cart">
                        </div>
                        <h3>Cart</h3>
                        <p class="text-muted">Your current cart list</p>
                    </a>
                </div>
                <div class="user-action flex-item col-8 col-sm-6 col-md-3">
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=order">
                        <div class="icon-action">
                            <img src="<?php echo $baseController->website_url ?>/assets/img/icon/box.png" alt="Order">
                        </div>
                        <h3>Order</h3>
                        <p class="text-muted">List of all your order</p>
                    </a>
                </div>
                <div class="user-action flex-item col-8 col-sm-6 col-md-3">
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=edit-address">
                        <div class="icon-action">
                            <img src="<?php echo $baseController->website_url ?>/assets/img/icon/truck.png" alt="Address">
                        </div>
                        <h3>Address</h3>
                        <p class="text-muted">Edit addresses for orders</p>
                    </a>
                </div>
                <div class="user-action flex-item col-8 col-sm-6 col-md-3">
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=edit-login">
                        <div class="icon-action">
                            <img src="<?php echo $baseController->website_url ?>/assets/img/icon/id-card.png" alt="User">
                        </div>
                        <h3>Login</h3>
                        <p class="text-muted">Edit login, name, password </p>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
require_once($baseController->website_path . "/template/_footer.php");