<?php

use Inc\Utils\Cart;
use Inc\Utils\User;
use Inc\Utils\Address;
use Inc\Database\DbItem;

require_once($baseController->website_path . "/template/_header.php");

$user = User::getCurrentUser();
$cart = Cart::getCartUser($user->id);
$cartItems = Cart::getCartItems($cart->id);
$address = Address::getAddress($user->userName);
$price = 0;

?>
    <main role="main" class="fit-height-section">
        <div class="jumbotron jumbotron-fluid small-jumbotron">
            <div class="container">
                <h1 class="display-4">Checkout</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
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
                                    <small class="text-muted"><?php echo $cartItem->quantity; ?> item<?php echo $cartItem->quantity > 1 ? "s" : "" ?></small>
                                </div>
                                <span class="text-muted">€<?php echo($item->price * $cartItem->quantity); ?></span>
                            </li>

                        <?php } ?>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div class="text-muted">
                                <h6 class="my-0">Shipping cost:</h6>
                                <small class="text-muted">Free shipping</small>
                            </div>
                            <span class="text-muted">€0</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (EUR)</span>
                            <strong>$<?php echo $price ?></strong>
                        </li>
                    </ul>

                </div>
                <div class="col-md-8 order-md-1">
                    <form class="needs-validation was-validated" novalidate="">
                        <h4 class="mb-3">User information</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName">First name</label>
                                <input type="text" class="form-control" id="firstName" placeholder=""
                                       value="<?php echo $user->firstName; ?>" readonly>
                                <div class="invalid-feedback">
                                    Valid first name is required.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName">Last name</label>
                                <input type="text" class="form-control" id="lastName" placeholder=""
                                       value="<?php echo $user->lastName; ?>" readonly>
                                <div class="invalid-feedback">
                                    Valid last name is required.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="username">Username</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@</span>
                                </div>
                                <input type="text" class="form-control" id="username" placeholder="Username"
                                       value="<?php echo $user->userName; ?>" readonly>
                                <div class="invalid-feedback" style="width: 100%;">
                                    Your username is required.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="you@example.com"
                                   value="<?php echo $user->userEmail; ?>" readonly>
                        </div>

                        <a class="" href="page.php?name=edit-login">Edit user information</a>
                        <br><br>

                        <h4 class="mb-3">Billing address</h4>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="zip">Department</label>
                                <input type="text" class="form-control" id="zip" placeholder="Department"
                                       value="<?php echo $address->department; ?>" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="zip">Class</label>
                                <input type="text" class="form-control" id="zip" placeholder="Class"
                                       value="<?php echo $address->class; ?>" readonly>
                            </div>
                        </div>
                        <a class="" href="page.php?name=edit-address">Edit user information</a>
                        <br><br>


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

                                <input type="text" class="form-control" id="cc-name" placeholder="" required>
                                <small class="text-muted">Full name as displayed on card</small>
                                <div class="invalid-feedback">
                                    Name on card is required
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cc-number">Credit card number</label>
                                <input type="text" class="form-control" id="cc-number" placeholder="" required>
                                <div class="invalid-feedback">
                                    Credit card number is required
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="cc-expiration">Expiration</label>
                                <input type="text" class="form-control" id="cc-expiration" placeholder="" required="">
                                <div class="invalid-feedback">
                                    Expiration date required
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="cc-expiration">CVV</label>
                                <input type="text" class="form-control" id="cc-cvv" placeholder="" required="">
                                <div class="invalid-feedback">
                                    Security code required
                                </div>
                            </div>
                        </div>
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </main>


<?php

require_once($baseController->website_path . "/template/_footer.php");
