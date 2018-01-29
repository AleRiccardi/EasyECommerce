<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 13/01/2018
 * Time: 01:30
 */

namespace Inc\Admin;

use Inc\Base\BaseController;
use Inc\Database\DbAddress;
use Inc\Database\DbCategory;
use Inc\Database\DbImage;
use Inc\Database\DbUser;
use Inc\Utils\Order;
use Inc\Utils\User;

class OverviewAdmin extends BaseController {

    public $gotValue = null;

    /**
     * Overview constructor.
     */
    public function __construct() {
        // BaseController
        parent::__construct();

        // Check if have privilege
        if (!User::isAdmin()) {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function register() {


        // in this case unless class
        if (!isset($_GET['overview'])) {
            return false;
        } else {
            // what we matters
            $this->gotValue = $_GET['overview'];

            if ($this->gotValue == "") {
                //show overview
                $this->showDashboard();
            } else {
                // show else
                $this->showSpecific($this->gotValue);
            }
        }
    }

    public function showDashboard() {
        $this->getMain();
    }

    public function showSpecific($name) {
        echo("<h3>$name</h3>");
    }


    private function getMain() {
        # all categories
        $filter = [
            "dateCreation" => "ASC"
        ];
        $categories = DbCategory::getFiltered($filter, null, "object");
        ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
            <h1 class="admin-title">Overview</h1>
            <h2>List recent categories</h2>
            <section class="row text-center placeholders">
                <?php
                $i = 0;
                if ($categories) {
                    foreach ($categories as $category) {
                        if ($i++ >= 4) break;
                        # current category
                        $imageCat = DbImage::getSingle(["id" => $category->idImage], 'object');
                        ?>
                        <div class="category-overview col-6 col-sm-3 placeholder">
                            <a onclick="window.location='?name=admin-area&category&edit&id=<?php echo $category->id; ?>';">
                                <div style=" background-image: url(' <?php echo $this->website_url . $imageCat->path; ?>');"
                                     width="200" height="200" class="img-category-admin rounded-circle"
                                     alt="Category <?php echo $category->title; ?> image">
                                </div>
                                <h4><?php echo $category->title; ?></h4>
                            </a>
                        </div>
                        <?php
                    }
                } else {
                    echo "<span class='pl-3'>No category.</span>";
                }
                ?>
            </section>              <h2>List recent orders</h2>
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
                    $orders = Order::getAllOrders();
                    if ($orders) {
                        $i = 0;
                        foreach ($orders as $order) {
                            # Limit to 15 orders
                            if ($i++ >= 15) break;

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
                    } else {
                        echo "No orders.";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </main>
        <?php
    }
}