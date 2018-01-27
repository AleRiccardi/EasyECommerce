<?php

use Inc\Utils\User;
use Inc\Utils\Order;
use Inc\Utils\Cart;
use Inc\Utils\GeneralCost;
use Inc\Database\DbAddress;
use Inc\Database\DbItem;
use Inc\Database\DbCategory;

if (!$user = User::getCurrentUser()) {
    die();
}
$orders = Order::getAllOrders($user->id);

require_once($baseController->website_path . "/template/_header.php");
?>
    <section class="brc-cont">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?name=user">User</a></li>
                    <li class="breadcrumb-item active">Order</li>
                </ol>
            </nav>
        </div>
    </section>
    <main role="main" class="fit-height-section">
        <div class="jumbotron jumbotron-fluid small-jumbotron">
            <div class="container">
                <h1 class="display-4">Order</h1>
                <h4>Number of order: <span class="badge badge-primary "><?php echo count($orders); ?></span></h4>
            </div>
        </div>

        <div class="container">
            <?php if ($orders) { ?>
                <div id="accordion">
                    <?php
                    foreach ($orders as $order) {
                        $itemsOrder = Cart::getCartItems($order->id);
                        $address = DbAddress::getSingle(["id" => $order->idAddress], "object");
                        ?>
                        <div class="card">
                            <div class="card-header ch-order container" id="headingOne" data-toggle="collapse"
                                 data-target="#collapse<?php echo $order->id; ?>"
                                 aria-expanded="true" aria-controls="collapse<?php echo $order->id; ?>">
                                <div class="row">
                                    <div class="col-2">
                                    <span>
                                        Order made: <br><strong><?php echo date("d M Y", strtotime($order->dateDeliver)); ?></strong>
                                    </span>
                                    </div>
                                    <div class="col-2">
                                    <span>
                                        Total: <br><strong>€<?php echo $order->finalPrice; ?></strong>
                                    </span>
                                    </div>
                                    <div class="col-3">
                                    <span>
                                        Delivered to: <br><strong><?php echo $address->department . " - " . $address->class; ?></strong>
                                    </span>
                                    </div>
                                    <div class="ml-auto col-2 text-center">
                                    <span>
                                        <small class="text-muted">Order: # <strong><?php echo $order->id; ?></strong></small>
                                    </span>
                                        <br>
                                        <span>
                                        <small class="text-muted">Number items: <strong><?php echo count($itemsOrder); ?></strong></small>
                                    </span>
                                    </div>

                                </div>
                            </div>

                            <div id="collapse<?php echo $order->id; ?>" class="collapse"
                                 aria-labelledby="heading<?php echo $order->id; ?>"
                                 data-parent="#accordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-9">
                                            <h5>Items detail</h5>
                                            <ul>
                                                <?php
                                                foreach ($itemsOrder as $itemOrder) {
                                                    $item = DbItem::getSingle(["id" => $itemOrder->idItem], 'object');
                                                    $category = DbCategory::getSingle(["id" => $item->idCategory], 'object');
                                                    ?>
                                                    <li>
                                                        <h7><?php echo $item->title; ?></h7>
                                                        <ul>
                                                            <li>Quantity: <?php echo $itemOrder->quantity; ?></li>
                                                            <li>Price: €<?php echo $item->price; ?></li>
                                                            <li>Total:
                                                                €<?php echo $itemOrder->quantity * $item->price; ?></li>
                                                            <li>Description: <?php echo $item->description; ?></li>
                                                            <li>Category: <a
                                                                        href="<?php echo $baseController->website_url . "/page.php?name=category&category=" . $category->slug; ?>">
                                                                    <?php echo $category->title; ?></a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                            <p>
                                                <?php
                                                $cost = GeneralCost::getCartShippmentPayment($order->id);
                                                echo "Shipment cost: €" . $cost;
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            } else {
                ?>
                <div class="row">
                    <p class='lead'>Your Order list is empty, hurry hup to buy somethings.</p>
                </div>
                <div class="row">
                    <a class="btn btn-success" href='page.php?name=shop'>Go to shop</a>
                </div>
                <?php
            }
            ?>
        </div>
    </main>


<?php

require_once($baseController->website_path . "/template/_footer.php");
