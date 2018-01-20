<?php

namespace Inc\Utils;

use Inc\Database\DbAddress;
use Inc\Database\DbUser;

/**
 * Class Address
 *
 * @package Inc\Classes
 */
class Address {

    /**
     * Init function run form the Init class every
     * time that we load a page.
     */
    public function register() {
        self::editAddress();
    }

    /**
     * Permit to retrieve the address of a specific user.
     *
     * @param $userName username of the user
     *
     * @return array|null array of objects, if single will be an object,
     *                    null if error.
     */
    public static function getAddress($userName){
        $user = User::getBy($userName,"USERNAME");
        $res = DbAddress::getSingle(["id" => $user->idAddress], "OBJECT");
        return $res;
    }

    /**
     * When clicked the button editAddress in edit-address.php
     * page the form send $_POST information and that function
     * permit to catch them.
     *
     * @return bool
     */
    public static function editAddress() {
        if (isset($_POST['editAddress'])) {
            $user = User::getCurrentUser();

            $address = null;
            $data = array(
                "department" => $_POST['department'],
                "class" => $_POST['class'],
            );

            $existAddress = DbAddress::getSingle(["id" => $user->idAddress], "OBJECT"); // Get the address
            // if exist
            if($existAddress){
                $res = DbAddress::update($data, ["id" => $existAddress->id]);
                return $res ? true : false;
            } else {
                // if doesn't exist it will be create
                $idAddress = DbAddress::insert($data); // return the id of the row that is added
                $res = DbUser::update(["idAddress" => $idAddress], ["userName" => $user->userName]); // connect the address row with the user idAddress
                return $res ? true : false;
            }
        }
        // default
        return false;
    }

}