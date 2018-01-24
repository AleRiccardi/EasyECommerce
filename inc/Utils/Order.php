<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 23/01/2018
 * Time: 16:48
 */

namespace Inc\Utils;


use Inc\Database\DbCart;
use Inc\Database\DbModel;

class Order {

    /**
     * @param $idUser
     *
     * @return object null
     */
    public static function getLastPayment($idUser) {
        $returnCart = null; #the cart that will be returned

        while (true) {
            # try to find one already existing
            $recentIdCart = null;
            $recentDateCart = null;
            $where = ["idUser" => $idUser];
            $carts = DbCart::get($where, "object");
            foreach ($carts as $cart) {
                if (strtotime($cart->dateDeliver) > strtotime($recentDateCart)) {
                    $recentDateCart = $cart->dateDeliver;
                    $recentIdCart = $cart->id;
                }
            }

            $recentOrder = DbCart::getSingle(["id" => $recentIdCart], "object");
            if($recentOrder) {
                $nowLess10 = date('Y-m-d H:i:s', strtotime('-50 minutes'));

                if (strtotime($recentOrder->dateDeliver) > strtotime($nowLess10)) {
                    return $recentOrder;
                } else {
                    return null;
                }
            }
        }
    }


}