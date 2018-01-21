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
     * Get current cart of a specific user, if doesn't
     * exist it will be created.
     *
     * @param $idUser
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
     * @param      $idCart
     * @param null $idItem
     *
     * @return array|bool
     */
    public static function getCartItems($idCart, $idItem = null) {
        $where = ["idCart" => $idCart];
        if ($idItem) $where["idItem"] = $idItem;

        $carts = DbCartItem::get($where, "object");
        return $carts;
    }

    /**
     * Add an item in the cart and addiction the quantity
     * if already exist.
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
        ?>
        <table class="table table-hover">
            <tbody>

            <?php

            foreach ($cartItems as $cartItem) {
                $item = DbItem::getSingle(["id" => $cartItem->idItem], 'object');
                $where = ["id" => $item->idImage];
                $image = DbImage::getSingle($where, 'object');
                $imageUrl = $baseC->website_url . $image->path;

                ?>

                <tr>
                    <td class="text-left">
                        <div class='card-page-item-img-cont'>
                            <div class='middle-h-cont'>
                                <img id='card-item-img' class='card-item-img middle-h-item'
                                     src="<?php echo $imageUrl; ?>"
                                     alt='Card image cap'>
                            </div>
                        </div>
                    </td>
                    <td class="text-left">
                        <span class='card-item-title' id='card-item-title'>
                            <?php echo $item->title; ?>
                            </span>
                    </td>
                    <td class="text-right">
                        <div class="middle-h-item ml-auto">
                            Quantity <input value="<?php echo $cartItem->quantity; ?>" style="width: 50px">
                        </div>
                    </td>
                    <td class="text-right">
                        <div class="td-cont">
                            <span class='badge badge-secondary price-badge middle-h-item' id='card-item-quantity'>
                                €<?php echo $cartItem->quantity * $item->price; ?>
                            </span>
                        </div>
                    </td>
                    <td class="text-right">
                        <div class="middle-h-item btn-trash " data-item="<?php echo $item->id ?>" data-user="<?php echo $idUser ?>">
                            <img src="<?php echo $dirC->iconUrl . "garbage.png" ?>">
                        </div>
                    </td>
                </tr>
                <?php
            } ?>
            </tbody>
        </table>
        <?php
    }

    public static function displayReport($idUser) {
        $cart = Cart::getCartUser($idUser);
        $cartItems = Cart::getCartItems($cart->id);
        $price = 0;
        $totPrice = 0;

        $shipPayment = 5;

        foreach ($cartItems as $cartItem) {
            $item = DbItem::getSingle(["id" => $cartItem->idItem], 'object');
            $price = ($price + ($item->price * $cartItem->quantity));
        }

        $totPrice = $price + $shipPayment;
        ?>

        <div>
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your report</span>
            </h4>
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
                            <li>
                                Department: Informatics
                            </li>
                            <li>
                                Class: A1
                            </li>
                            <li>
                                <small class="text-muted"><a href="#">Change destiation</a></small>
                            </li>
                        </ul>
                    </div>
                    <span class="text-muted">€<?php echo $shipPayment; ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <span>Total (EUR)</span>
                    <strong>€<?php echo $totPrice; ?></strong>
                </li>
                <a href="#" class="list-group-item go-to-checkout">
                    <span>Go to checkout</span>
                </a>
            </ul>


        </div>
        <?php
    }
}