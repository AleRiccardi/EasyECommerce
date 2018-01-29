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
                if (strtotime($cart->dateDeliver) > strtotime($recentCart->dateDeliver)) {
                    $recentCart = $cart;
                }
            } else {
                $recentCart = $cart;
            }
        }

        $recentOrder = DbCart::getSingle(["id" => $recentCart->id], "object");
        if ($recentOrder) {
            $nowLess10 = date('Y-m-d H:i:s', strtotime('-50 minutes'));

            if (strtotime($recentOrder->dateDeliver) > strtotime($nowLess10)) {
                return $recentOrder;
            }
        }
        # default
        return null;

    }

    public static function getUserOrders($idUser) {
        $sql = "SELECT * FROM " . DbCart::getTableName() . " WHERE idUser = $idUser AND dateDeliver IS NOT NULL ORDER BY dateDeliver DESC";
        $res = DbCart::getResult($sql, "object");
        return $res;
    }

    public static function getAllOrders() {
        $sql = "SELECT * FROM " . DbCart::getTableName() . " WHERE dateDeliver IS NOT NULL ORDER BY dateDeliver DESC";
        $res = DbCart::getResult($sql, "object");
        return $res;
    }


}