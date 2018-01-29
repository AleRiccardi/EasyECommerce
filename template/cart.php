<?php

use Inc\Utils\Cart;
use Inc\Utils\User;

if (!$user = User::getCurrentUser()) {
    die();
}

$cartItems = Cart::getUserCartItem($user->id);

require_once($baseController->website_path . "/template/_header.php");
?>
    <!-- breadcrumb -->
    <section class="brc-cont">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?name=user">User</a></li>
                    <li class="breadcrumb-item active">Cart</li>
                </ol>
            </nav>
        </div>
    </section>
    <main role="main" class="fit-height-section">
        <div class="jumbotron jumbotron-fluid small-jumbotron">
            <div class="container">
                <h1 class="display-4">Cart</h1>
                <h4>Number of item: <span class="badge badge-primary cart-page-num-item"><?php echo count($cartItems); ?></span></h4>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-between">

                <div class="col-md-9">
                    <div id="cart" class="container">
                        <?php Cart::displayCart($user->id); ?>
                    </div>
                </div>

                <div class="report-cart col-md-3 mb-3">
                    <div id="report">
                        <?php Cart::displayReport($user->id); ?>
                    </div>
                </div>
            </div>
        </div>

    </main>


<?php

require_once($baseController->website_path . "/template/_footer.php");
