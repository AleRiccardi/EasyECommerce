<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 19/01/2018
 * Time: 17:16
 */

namespace Inc\Ajax;

include ("AjaxEngine.php");
class CartAjax extends AjaxEngine {


    public function printValue () {

        if (!empty($idUser = $this->get('idUser')) &&
            !empty($idProduct = $this->get('idProduct')) &&
            !empty($quantity = $this->get('quantity'))) {

            echo "User: $idUser, Id product: $idProduct, quantity: $quantity";
        }
    }
}

$init = new CartAjax();