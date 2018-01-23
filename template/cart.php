<?php

use Inc\Utils\Cart;

$dirC = new \Inc\Base\DirController();
$user = \Inc\Utils\User::getCurrentUser();
require_once($baseController->website_path . "/template/_header.php");
?>
    <main role="main" class="fit-height-section">
        <div class="jumbotron jumbotron-fluid small-jumbotron">
            <div class="container-fluid">
                <h1 class="display-4">Cart</h1>
                <h4>Number of item: <span class="badge badge-primary cart-page-num-item">0</span></h4>
            </div>
        </div>
        <div class="container-fluid">
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
