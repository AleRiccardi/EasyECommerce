<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 23/01/2018
 * Time: 16:48
 */

namespace Inc\Utils;


use Inc\Database\DbCart;

class Order {

    /**
     * Catch a checkout request.
     */
    public function register() {
        if (isset($_POST['orderDelivered'])) {
            $idOrder = !empty($_GET["see-order"]) ? $_GET["see-order"] : null;
            if ($idOrder != null) {
                $data["dateDeliver"] = DbCart::now();
                DbCart::update($data, ["id" => $idOrder]);
            }
        }
    }

    /**
     * @param $idUser
     *
     * @return object null
     */
    public static function getLastPayment($idUser) {
        $returnCart = null; #the cart that will be returned

        $recentCart = null;
        $recentDateCart = null;
        $carts = DbCart::get(["idUser" => $idUser], "object");

        foreach ($carts as $cart) {
            if ($recentCart) {
                if (strtotime($cart->dateCheckout) > strtotime($recentCart->dateCheckout)) {
                    $recentCart = $cart;
                }
            } else {
                $recentCart = $cart;
            }
        }
        $recentOrder = DbCart::getSingle(["id" => $recentCart->id], "object");
        if ($recentOrder) {
            $nowLess10 = date('Y-m-d H:i:s', strtotime('-50 minutes'));
            if (strtotime($recentOrder->dateCheckout) > strtotime($nowLess10)) {
                return $recentOrder;
            }
        }
        # default
        return null;

    }

    public static function getUserOrders($idUser) {
        $sql = "SELECT * FROM " . DbCart::getTableName() . " WHERE idUser = $idUser AND dateCheckout IS NOT NULL ORDER BY dateCheckout DESC";
        $res = DbCart::getResult($sql, "object");
        return $res;
    }

    public static function getAllOrders() {
        $sql = "SELECT * FROM " . DbCart::getTableName() . " WHERE dateCheckout IS NOT NULL ORDER BY dateCheckout DESC";
        $res = DbCart::getResult($sql, "object");
        return $res;
    }


}