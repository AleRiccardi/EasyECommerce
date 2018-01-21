<?php

use Inc\Utils\Cart;

$dirC = new \Inc\Base\DirController();
$user = \Inc\Utils\User::getCurrentUser();
require_once($baseController->website_path . "/template/_header.php");
?>

    <main role="main" class="page container fit-height-section">
        <div class="row justify-content-between">
            <div class="col-md-7">
                <h1 class="display-4">Billing address</h1>
                <br><br>
                <div id="cart" class="container">
                    <div class="row">
                        <?php Cart::displayCart($user->id); ?>
                    </div>

                </div>
            </div>

            <div class="report-cart col-md-4 mb-4">
                <?php Cart::displayReport($user->id); ?>
            </div>
        </div>

    </main>


<?php

require_once($baseController->website_path . "/template/_footer.php");
