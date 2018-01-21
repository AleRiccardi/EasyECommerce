<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 19/01/2018
 * Time: 17:16
 */

namespace Inc\Ajax;

use Inc\Utils\Cart;

include("AjaxEngine.php");

class CartAjax extends AjaxEngine {


    public function printValue() {
        if (!empty($idUser = $this->get('idUser')) &&
            !empty($idItem = $this->get('idProduct')) &&
            !empty($quantity = $this->get('quantity'))) {
            echo Cart::addItem($idUser, $idItem, $quantity) ? "added" : "error";
        }
    }

    public function getNumItemCart() {
        if (!empty($idUser = $this->get('idUser'))) {
            $cart = Cart::getCartUser($idUser);
            echo count(Cart::getCartItems($cart->id));
        }
    }
}

$init = new CartAjax();