<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 23/01/2018
 * Time: 16:38
 */

namespace Inc\Utils;


class GeneralPrice {
    const SHIPPING_COST = 5;
    const FREE_SHIPPING_TOT_PRICE = 20;

    public static function getCartShippmentPayment($totPrice) {
        if($totPrice < self::FREE_SHIPPING_TOT_PRICE){
            return self::SHIPPING_COST;
        } else {
            return 0;
        }

    }
}