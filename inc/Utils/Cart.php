<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 20/01/2018
 * Time: 01:42
 */

namespace Inc\Utils;


use Inc\Database\DbCart;
use Inc\Database\DbCartItem;

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

}