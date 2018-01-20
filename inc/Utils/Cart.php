<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 20/01/2018
 * Time: 01:42
 */

namespace Inc\Utils;


use Inc\Database\DbCartItem;

class Cart extends DbModel {

    function addProduct($idUser, $idProduct, $quantity){
        $dataC = [
            "idCart" => ""
        ];
        $dataCI = [
            "idCart" => ""
        ];
        $idCartItem = DbCartItem::insert();
    }

}