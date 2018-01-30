<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 29/01/2018
 * Time: 01:09
 */

namespace Inc\Admin;


use Inc\Base\BaseController;
use Inc\Database\DbAddress;
use Inc\Database\DbCart;
use Inc\Database\DbCartItem;
use Inc\Database\DbCategory;
use Inc\Database\DbItem;
use Inc\Database\DbUser;
use Inc\Utils\GeneralPrice;
use Inc\Utils\Order;
use Inc\Utils\User;

class OrderAdmin extends BaseController {

    /**
     * Product constructor.
     */
    public function __construct() {
        // BaseController
        parent::__construct();

        // Check if have privilege
        if (!User::isAdmin()) {
            return false;
        }
    }

    public function register() {
        // in this case unless class
        if (isset($_GET['order'])) {

            if (isset($_GET['see-order'])) {
                $this->seeOrder();
            } else {
                $this->getMain("Order");
            }

        }
    }

    public function seeOrder() {
        $idOrder = !empty($_GET["see-order"]) ? $_GET["see-order"] : null;
        $order = DbCart::getSingle(["id" => $idOrder], "object");
        $itemsOrder = DbCartItem::get(["idCart" => $order->id], "object");
        $user = DbUser::getSingle(["id" => $order->idUser], "object");
        $address = DbAddress::getSingle(["id" => $order->idAddress], "object");

        ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <div class="row">
                <div class="col-12 col-md-10">
                    <h1 class="admin-title">Order <?php if (!$order->dateDeliver) { ?><span
                                class="badge badge-secondary">New</span> <?php } ?></h1>
                    <p class="lead">
                        <?php if (!$order->dateDeliver) { ?>
                            Look to all the items to deliver and then when the order will arrived to the address click on
                            <span class="text-primary">delivered</span>.
                        <?php } else { ?>
                                Order already delivered.
                        <?php } ?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 mb-4">
                    <div class="order-detail-success">
                        <h5>Order detail</h5>
                        <p>
                            Under there are all the information about your order.
                        </p>
                        <ul>
                            <li>Order code: <?php echo $order->id; ?></li>
                            <li>Date deliver order: <?php echo $order->dateCheckout; ?></li>
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
                                                            href="<?php echo $this->website_url . "/page.php?name=category&category=" . $category->slug; ?>">
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
                    <?php if (!$order->dateDeliver) { ?>
                        <form class="form-add-new" method="post"
                              action="?name=admin-area&order&see-order=<?php echo $idOrder; ?>"
                              enctype="multipart/form-data"
                              name="orderDelivered">
                            <button class="btn btn-primary btn-lg mt-3 ml-1" name="orderDelivered" type="submit">
                                Delivered
                            </button>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </main>

        <?php
    }

    /**
     * @param $name
     */
    public function getMain($name) {
        $orders = Order::getAllOrders();

        ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <h1 class="admin-title"><?php echo $name; ?></h1>
            <h4>List Order</h4>
            <div class="table-responsive">
                <table class="table table-admin table-striped table-sm">
                    <caption>List of the all orders</caption>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date Checkout</th>
                        <th>Date Deliver</th>
                        <th>Price</th>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Department</th>
                        <th>Class</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($orders) {
                        foreach ($orders as $order) {
                            $user = DbUser::getSingle(["id" => $order->idUser], "object");
                            $address = DbAddress::getSingle(["id" => $order->idAddress], "object");
                            ?>

                            <tr class="<?php echo $order->dateDeliver ? "text-muted" : ""; ?>" onclick="
                                    window.location='?name=admin-area&order&see-order=<?php echo $order->id; ?>' ;">
                                <td><?php echo $order->id; ?></td>
                                <td><?php echo $order->dateCheckout; ?></td>
                                <td><?php echo $order->dateDeliver; ?></td>
                                <td>€ <?php echo $order->finalPrice; ?></td>
                                <td><?php echo $user->userName; ?></a></td>
                                <td><?php echo $user->firstName; ?></a></td>
                                <td><?php echo $user->lastName; ?></td>
                                <td><?php echo $address->department ?></td>
                                <td><?php echo $address->class; ?></td>
                            </tr>
                            <?php
                        }
                    } ?>
                    </tbody>
                </table>
            </div>
        </main>
        <?php
    }

}