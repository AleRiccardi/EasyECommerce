<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 14/01/2018
 * Time: 19:03
 */

namespace Inc\Classes;


class Category {
    /**
     * Init function run form the Init class every
     * time that we load a page.
     */
    public function register() {
        self::catchAddCategory();
    }


    /**
     * When clicked the button editAddress in edit-address.php
     * page the form send $_POST information and that function
     * permit to catch them.
     *
     * @return bool
     */
    public static function catchAddCategory() {
        if (isset($_POST['addCategory'])) {
            $user = User::getCurrentUser();

            $address = null;
            $data = array(
                "department" => $_POST['department'],
                "class" => $_POST['class'],
            );

            $existAddress = DbAddress::get(["id" => $user->idAddress], "OBJECT"); // Get the address
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