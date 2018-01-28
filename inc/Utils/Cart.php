<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 20/01/2018
 * Time: 01:42
 */

namespace Inc\Utils;


use Inc\Base\BaseController;
use Inc\Base\DirController;
use Inc\Database\DbAddress;
use Inc\Database\DbCart;
use Inc\Database\DbCartItem;
use Inc\Database\DbImage;
use Inc\Database\DbItem;

class Cart {

    /**
     * Function to be called when you want to add an item in the cart.
     * It will be checked if the cart exist (if doesn't exist, it will
     * be created) and then connected the new item with the relative
     * quantity.
     *
     * @param $idUser
     * @param $idItem
     * @param $quantity
     *
     * @return bool true on success, false otherwise.
     */
    public static function addItem($idUser, $idItem, $quantity) {
        # Check if the cart exist
        if (!$cart = self::getCartUser($idUser)) {
            return false;
        }
        $idCart = $cart->id;

        return self::addItemToCart($idCart, $idItem, $quantity);
    }

    /**
     *
     *
     * @param $idUser
     * @param $idItem
     * @param $quantity
     *
     * @return bool true on success, false otherwise.
     */
    public static function changeQuantity($idUser, $idItem, $quantity) {
        # Check if the cart exist
        if (!$cart = self::getCartUser($idUser)) {
            return false;
        }
        $idCart = $cart->id;

        # check if the item is already stored in cart (addiction the quantity)
        $items = self::getCartItems($idCart, $idItem);
        if (!empty($items)) {
            # the item is already stored
            foreach ($items as $item) {
                if ($item->idItem == $idItem) {

                    $newQuantity = $quantity;

                    $data = [
                        "quantity" => $newQuantity,
                    ];

                    $where = [
                        "idCart" => $idCart,
                        "idItem" => $idItem,
                    ];

                    return DbCartItem::update($data, $where) ? true : false;
                }
            }
        }
    }

    /**
     * Get current cart of a specific user, if doesn't
     * exist it will be created.
     *
     * @param int $idUser
     *
     * @return false|object
     */
    public static function getCartUser($idUser) {
        $returnCart = null; #the cart that will be return

        while (true) {
            # try to find one already existing
            $where = ["idUser" => $idUser];
            $carts = DbCart::get($where, "object");
            foreach ($carts as $cart) {
                if ($cart && !$cart->dateDeliver) {
                    return $cart;
                }
            }

            # If doesn't exist we create it
            $dataC = [
                "idUser" => $idUser,
                "dateCreation" => DbCart::now(),
            ];
            DbCart::insert($dataC);
        }
    }

    /**
     * @param int $idCart
     * @param int $idItem
     *
     * @return array
     */
    public static function getCartItems($idCart, $idItem = null) {
        $where = ["idCart" => $idCart];
        if ($idItem) $where["idItem"] = $idItem;

        $carts = DbCartItem::get($where, "object");
        return $carts;
    }

    /**
     * @param $idUser
     *
     * @return array
     */
    public static function getUserCartItem($idUser) {
        $cart = self::getCartUser($idUser);
        $cartItems = self::getCartItems($cart->id);
        return $cartItems;
    }

    /**
     * Add an item in the cart and it can be used also for change
     * quantity (positive or negative).
     *
     * @param $idCart
     * @param $idItem
     * @param $quantity
     *
     * @return bool true on success, false otherwise.
     */
    public static function addItemToCart($idCart, $idItem, $quantity) {
        # check if the item is already stored in cart (addiction the quantity)
        $items = self::getCartItems($idCart, $idItem);

        if (!empty($items)) {
            # the item is already stored
            foreach ($items as $item) {
                if ($item->idItem == $idItem) {

                    $newQuantity = $item->quantity + $quantity;

                    $data = [
                        "quantity" => $newQuantity,
                    ];

                    $where = [
                        "idCart" => $idCart,
                        "idItem" => $idItem,
                    ];

                    return DbCartItem::update($data, $where) ? true : false;
                }
            }
        } else {
            # it's necessary to store the item inside the cart
            if ($idCart) {
                # data cart_item
                $dataCI = [
                    "idCart" => "$idCart",
                    "idItem" => $idItem,
                    "quantity" => $quantity,
                ];

                return DbCartItem::insert($dataCI) ? true : false;
            }
        }
    }


    /**
     * @param $idUser
     */
    public static function displayCart($idUser) {
        $dirC = new DirController();
        $baseC = new BaseController();
        $cart = Cart::getCartUser($idUser);
        $cartItems = Cart::getCartItems($cart->id);
        if (!empty($cartItems)) {
            ?>
            <div class="row">
                <table class="table table-hover">
                    <caption>List of all the products in the cart</caption>
                    <thead>
                    <tr>
                        <th scope="col" class="text-left"><h3>Item</h3></th>
                        <th scope="col" class="text-center">Quantity</th>
                        <th scope="col" class="text-center">Price</th>
                        <th scope="col" class="text-center"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php

                    foreach ($cartItems as $cartItem) {
                        $item = DbItem::getSingle(["id" => $cartItem->idItem], 'object');
                        $where = ["id" => $item->idImage];
                        $image = DbImage::getSingle($where, 'object');
                        $imageUrl = $baseC->website_url . $image->path;
                        ?>

                        <tr>
                            <td class="text-left" scope="row">
                                <div class="middle-h-cont ml-auto">
                                    <div class='card-page-item-img-cont middle-h-item'>
                                        <div class='middle-h-cont'>
                                            <img id='card-item-img' class='card-item-img middle-h-item'
                                                 src="<?php echo $imageUrl; ?>"
                                                 alt="<?php echo $item->title; ?>">
                                        </div>
                                    </div>
                                    <div class="cart-page-info-product middle-h-item">
                                        <span class='card-page-item-title' id='card-item-title'>
                                            <?php echo $item->title; ?>
                                        </span>
                                        <span class="price-cart">
                                            Single: €<?php echo $item->price; ?>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="middle-h-cont ml-auto quantity-cont">
                                    <input class="change-quantity middle-h-item"
                                           value="<?php echo $cartItem->quantity; ?>"
                                           type="number" data-item="<?php echo $item->id ?>"
                                           data-user="<?php echo $idUser ?>">
                                    <div class="cont-btn-change-quantity"></div>
                                </div>
                            </td>
                            <td>
                                <div class="td-cont text-center">
                                    <span class='price-badge'
                                          id='card-item-quantity'>
                                        €<?php echo $cartItem->quantity * $item->price; ?>
                                    </span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-trash" data-item="<?php echo $item->id ?>"
                                     data-user="<?php echo $idUser ?>">
                                    <img src="<?php echo $dirC->iconUrl . "garbage.png" ?>" alt="Garbage">
                                </div>
                            </td>
                        </tr>
                        <?php
                    } ?>
                    </tbody>
                </table>
            </div>
            <?php
        } else { ?>
            <div class="row">
                <p class='lead'>Your cart is empty, go to the shop section and when you
                    see something that might
                    interest you, select the quantity and click on add.</p>
                <a class="btn btn-success" href='page.php?name=shop'>Go to shop</a>
            </div>
            <?php
        }

    }

    public static function displayReport($idUser) {
        $user = User::getBy($idUser, "id");
        $cart = Cart::getCartUser($idUser);
        $cartItems = Cart::getCartItems($cart->id);
        $address = Address::getAddress($user->id);
        $price = 0;
        $totPrice = 0;


        if (!empty($cartItems)) {

            foreach ($cartItems as $cartItem) {
                $item = DbItem::getSingle(["id" => $cartItem->idItem], 'object');
                $price = ($price + ($item->price * $cartItem->quantity));
            }

            $shipPayment = GeneralCost::getCartShippmentPayment($price);
            $totPrice = $price + $shipPayment;
            ?>


            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Subtotal</h6>

                    </div>

                    <span class="text-muted">€<?php echo $price; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Shipping cost:</h6>
                        <ul class="shipping-info-cart">
                            <?php if ($address && !empty($address->department) && !empty($address->class)) { ?>
                                <li>
                                    Department: <span><?php echo $address->department ?></span>
                                </li>
                                <li>
                                    Class: <span><?php echo $address->class ?></span>
                                </li>
                                <li>
                                    <small class="text-muted"><a href="page.php?name=edit-address">Change destiation</a>
                                    </small>
                                </li>
                            <?php } else { ?>
                                <li>
                                    <small class="text-muted"><a href="page.php?name=edit-address">Set destiation</a>
                                    </small>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <span class="text-muted">€<?php echo $shipPayment; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <span>Total (EUR)</span>
                    <strong>€<?php echo $totPrice; ?></strong>
                </li>
                <a href="page.php?name=checkout" class="list-group-item go-to-checkout">
                    <span>Go to checkout</span>
                </a>
            </ul>


            <?php
        } else {
            echo " ";
        }
    }
}