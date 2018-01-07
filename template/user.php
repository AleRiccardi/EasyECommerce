<?php

use Inc\Database\DbUser;

//$res = DbUser::get(array("user_name" => $_SESSION['user_name']), "ARRAY_A");
$res = DbUser::get(array("user_name" => $_SESSION['user_name']), "OBJECT");
?>
<div class="page-user fit-height-section">

    <div class="jumbotron user-header">
        <div class="container">
            <div class="user-img-name middle-h-container">
                <div class="pu-img ">
                    <div class="profile-image" style="background-image: url('<?php echo $baseController->website_url ?>/assets/img/icon/user-image-small.png');"></div>
                </div>
                <div class="middle-h-item user-name">
                    <h1 class=""><?php echo $res[0]->user_name; ?></h1>
                    <span>Registered the <?php echo "20 Jan 17"; ?></span>
                </div>
            </div>
        </div>
    </div>
    <section class="user-body">
        <div class="container">
            <!-- Example row of columns -->
            <div class="row flex-container">
                <div class="user-action flex-item col-md-3">
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=user">
                        <div class="icon-action">
                            <img src="<?php echo $baseController->website_url ?>/assets/img/icon/cart.png" alt="logo">
                        </div>
                        <h3>Cart</h3>
                        <p>Your current cart list</p>
                    </a>
                </div>
                <div class="user-action flex-item col-md-3">
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=user">
                        <div class="icon-action">
                            <img src="<?php echo $baseController->website_url ?>/assets/img/icon/box.png" alt="logo">
                        </div>
                        <h3>Your Order</h3>
                        <p>List of all your order</p>
                    </a>
                </div>
                <div class="user-action flex-item col-md-3">
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=user">
                        <div class="icon-action">
                            <img src="<?php echo $baseController->website_url ?>/assets/img/icon/truck.png" alt="logo">
                        </div>
                        <h3>Your Address</h3>
                        <p>Edit addresses for orders</p>
                    </a>
                </div>
                <div class="user-action flex-item col-md-3">
                    <a href="<?php echo $baseController->website_url ?>/page.php?name=user">
                        <div class="icon-action">
                            <img src="<?php echo $baseController->website_url ?>/assets/img/icon/id-card.png" alt="logo">
                        </div>
                        <h3>Login</h3>
                        <p>Edit login, name, password </p>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>