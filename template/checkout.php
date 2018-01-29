<?php

use Inc\Utils\Cart;
use Inc\Utils\User;
use Inc\Utils\Address;
use Inc\Database\DbItem;
use \Inc\Utils\GeneralPrice;

if (!$user = User::getCurrentUser()) {
    die();
}

$cart = Cart::getCartUser($user->id);

if (!$cart)
    header("Location: $baseController->website_url/page.php?name=user");

$cartItems = Cart::getCartItems($cart->id);

if (!$cartItems)
    header("Location: $baseController->website_url/page.php?name=user");

$address = Address::getAddress($user->id);
$price = 0;
# Card field
$ccName = "";
$ccNumber = "";
$ccExpiration = "";
$ccCvv = "";

if (isset($_POST['cc-name']) && isset($_POST['cc-number']) &&
    isset($_POST['cc-expiration']) && isset($_POST['cc-cvv'])) {
    $ccName = !empty($_POST['cc-name']) ? $_POST['cc-name'] : "";
    $ccNumber = !empty($_POST['cc-number']) ? $_POST['cc-number'] : "";
    $ccExpiration = !empty($_POST['cc-expiration']) ? $_POST['cc-expiration'] : "";
    $ccCvv = !empty($_POST['cc-cvv']) ? $_POST['cc-cvv'] : "";
}

require_once($baseController->website_path . "/template/_header.php");


?>
    <!-- breadcrumb -->
    <section class="brc-cont">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="?name=user">User</a></li>
                    <li class="breadcrumb-item"><a href="?name=cart">Cart</a></li>
                    <li class="breadcrumb-item active" aria-current="">Checkout</li>
                </ol>
            </nav>
        </div>
    </section>
    <main role="main" class="fit-height-section">
        <div class="jumbotron jumbotron-fluid small-jumbotron">
            <div class="container">
                <h1 class="display-4">Checkout</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Your cart</span>
                        <span class="badge badge-secondary badge-pill"><?php echo count($cartItems); ?></span>
                    </h4>
                    <ul class="list-group mb-3">
                        <?php
                        foreach ($cartItems as $cartItem) {
                            $item = DbItem::getSingle(["id" => $cartItem->idItem], 'object');
                            $price = ($price + ($item->price * $cartItem->quantity));
                            ?>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0"><?php echo $item->title; ?></h6>
                                    <small class="text-muted"><?php echo $cartItem->quantity; ?>
                                        item<?php echo $cartItem->quantity > 1 ? "s" : "" ?></small>
                                </div>
                                <span class="text-muted">€<?php echo($item->price * $cartItem->quantity); ?></span>
                            </li>

                        <?php }
                        $shipPayment = GeneralPrice::getCartShippmentPayment($price);
                        $finalPrice = $price + $shipPayment;
                        ?>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div class="text-muted">
                                <h6 class="my-0">Shipping price:</h6>
                                <small class="text-muted">Free shipping</small>
                            </div>
                            <span class="text-muted">€<?php echo $shipPayment ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (EUR)</span>
                            <strong>$<?php echo $finalPrice ?></strong>
                        </li>
                    </ul>

                </div>
                <div class="col-md-8 order-md-1 mb-4">
                    <form class="form-checkout" method="post" action="page.php?name=checkout" name="checkoutForm">
                        <h4 class="mb-3">User information</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName">First name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder=""
                                       value="<?php echo $user->firstName; ?>" required>
                                <div class="invalid-feedback">
                                    Valid first name is required.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName">Last name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder=""
                                       value="<?php echo $user->lastName; ?>" required>
                                <div class="invalid-feedback">
                                    Valid last name is required.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="you@example.com"
                                   value="<?php echo $user->userEmail; ?>" readonly>
                        </div>
                        <br>
                        <h4 class="mb-3">Billing address</h4>
                        <p>Write the information of your university, that consist in a department and a class to permit
                            to receive the food in the best place for you.</p>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="zip">Department</label>
                                <input type="text" class="form-control" id="department" name="department"
                                       placeholder="Department"
                                       value="<?php echo $address ? $address->department : ""; ?>" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="zip">Class</label>
                                <input type="text" class="form-control" id="class" name="class"
                                       placeholder="Class" value="<?php echo $address ? $address->class : ""; ?>"
                                       required>
                            </div>
                        </div>
                        <hr class="mb-4">
                        <h4 class="mb-3">Payment</h4>
                        <div class="d-block my-3">
                            <div class="custom-control custom-radio">
                                <input id="credit" name="paymentMethod" type="radio" class="custom-control-input"
                                       checked=""
                                       required="">
                                <label class="custom-control-label" for="credit">Credit card</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="debit" name="paymentMethod" type="radio" class="custom-control-input"
                                       required="">
                                <label class="custom-control-label" for="debit">Debit card</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input"
                                       required="">
                                <label class="custom-control-label" for="paypal">Paypal</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cc-name">Name on card</label>

                                <input type="text" class="form-control" id="cc-name" name="cc-name"
                                       placeholder="Mario Rossi" value="<?php echo $ccName; ?>" required>
                                <small class="text-muted">Full name as displayed on card</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cc-number">Credit card number</label>
                                <input type="text" class="form-control" id="cc-number" name="cc-number"
                                       placeholder="0000 0000 0000 0000" value="<?php echo $ccNumber; ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="cc-expiration">Expiration</label>
                                <input type="text" class="form-control" id="cc-expiration" name="cc-expiration"
                                       placeholder="01/20" value="<?php echo $ccExpiration; ?>" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="cc-expiration">CVV</label>
                                <input type="text" class="form-control" id="cc-cvv" name="cc-cvv" placeholder="123"
                                       value="<?php echo $ccCvv; ?>" required>
                            </div>
                        </div>
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" name="checkoutForm" type="submit">
                            Continue to checkout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>


<?php

require_once($baseController->website_path . "/template/_footer.php");
