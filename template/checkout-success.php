<?php

use \Inc\Database\DbItem;
use \Inc\Database\DbCategory;
use \Inc\Utils\GeneralPrice;
use \Inc\Utils\User;
use \Inc\Utils\Order;
use \Inc\Utils\Cart;
use \Inc\Database\DbAddress;

if (!$user = User::getCurrentUser()) {
    die();
}

# wait for database after confirmation of order
sleep(1);

$order = Order::getLastPayment($user->id);
if (!$order)
    header("Location: $baseController->website_url/page.php?name=user");
$itemsOrder = Cart::getCartItems($order->id);
$address = DbAddress::getSingle(["id" => $order->idAddress], "object");

require_once($baseController->website_path . "/template/_header.php");

?>

    <main role="main" class="fit-height-section mb-5">
        <div class="jumbotron jumbotron-fluid small-jumbotron bg-success text-white">
            <div class="container">
                <h1 class="display-4">Order placed</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-10">
                    <h4>Congratulation</h4>
                    <p class="lead">
                        You placed an order. Now you just need to wait in your class for our tasty food.
                        <br> The delivery man usually arrives in less than 30 minutes, otherwise, the delivery price
                        will be reimbursed.
                    </p>
                </div>
            </div>
            <br/>
            <br/>
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="order-detail-success">
                        <h5>Order detail</h5>
                        <p>
                            Under there are all the information about your order.
                        </p>
                        <ul>
                            <li>Order code: <?php echo $order->id; ?></li>
                            <li>Date deliver order: <?php echo $order->dateDeliver; ?></li>
                            <li>Total: €<?php echo $order->finalPrice; ?></li>

                            <li>
                                <span class="text-primary">Customer:</span>
                                <ul>
                                    <li>First name: <?php echo $user->firstName; ?></li>
                                    <li>Last name: <?php echo $user->lastName; ?></li>
                                </ul>
                            <li>
                                <span class="text-primary">Address:</span>

                                <ul>
                                    <li>Department: <?php echo $address->department; ?></li>
                                    <li>Class: <?php echo $address->class; ?></li>

                                </ul>
                            </li>
                        </ul>
                        <hr class="mb-4">
                        <div class="row">
                            <div class="col-12 col-md-9">
                                <h6>Items detail</h6>
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
                                                <li>Total: €<?php echo $itemOrder->quantity * $item->price; ?></li>
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
                                    $price = GeneralPrice::getCartShippmentPayment($order->id);
                                    echo "Shipment price: €" . $price;
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <p>
                <a class="btn btn-success" href="page.php?name=user">User page</a>
            </p>
        </div>
    </main>


<?php
require_once($baseController->website_path . "/template/_footer.php");