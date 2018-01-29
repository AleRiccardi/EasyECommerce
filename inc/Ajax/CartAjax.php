<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 19/01/2018
 * Time: 17:16
 */

namespace Inc\Ajax;

use Inc\Base\BaseController;
use Inc\Database\DbCartItem;
use Inc\Database\DbImage;
use Inc\Database\DbItem;
use Inc\Utils\Cart;
use Inc\Utils\User;

include("AjaxEngine.php");

class CartAjax extends AjaxEngine {

    public function addItem() {
        if (!empty($idUser = $this->get('idUser')) &&
            !empty($idItem = $this->get('idProduct')) &&
            !empty($quantity = $this->get('quantity'))) {
            echo Cart::addItem($idUser, $idItem, $quantity) ? true : -1;
        } else {
            echo false;
        }
    }

    public function changeQuantity() {
        if (!empty($idUser = $this->get('idUser')) &&
            !empty($idItem = $this->get('idItem')) &&
            !empty($quantity = $this->get('quantity'))) {
            echo Cart::changeQuantity($idUser, $idItem, $quantity);
        }
    }

    public function getNumItemsCart() {
        if (!empty($idUser = $this->get('idUser'))) {
            echo count(Cart::getUserCartItem($idUser));
        }
    }

    public function getCustomItemCart() {
        if (!empty($idUser = $this->get('idUser'))) {
            $baseC = new BaseController();
            $cart = Cart::getCartUser($idUser);
            $cartItems = Cart::getCartItems($cart->id);
            $return = array();
            foreach ($cartItems as $cartItem) {
                $item = DbItem::getSingle(["id" => $cartItem->idItem], 'object');
                if($item->idImage) {
                    $where = ["id" => $item->idImage];
                    $image = DbImage::getSingle($where, 'object');
                    $imageUrl = $baseC->website_url . $image->path;
                } else {
                    $imageUrl = $baseC->website_url ."/assets/img/no-image.jpg";
                }
                if ($item) {
                    $return[] = ["imgUrl" => "$imageUrl", "title" => $item->title, "quantity" => $cartItem->quantity];
                }
            }

            $json_string = json_encode($return, JSON_PRETTY_PRINT);
            echo $json_string;
        }
    }

    public function trashCartItem() {
        if (!empty($idUser = $this->get('idUser')) && !empty($idItem = $this->get('idItem'))) {
            $cart = Cart::getCartUser($idUser);
            $itemCarts = Cart::getCartItems($cart->id, $idItem);
            echo DbCartItem::delete($itemCarts[0]->id);
        }
    }


    public function refreshCart() {
        if (!empty($idUser = $this->get('idUser'))) {
            Cart::displayCart($idUser);
        }
    }

    public function refreshReport() {
        if (!empty($idUser = $this->get('idUser'))) {
            Cart::displayReport($idUser);
        }
    }
}

$init = new CartAjax();