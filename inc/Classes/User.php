<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 07/01/2018
 * Time: 04:54
 */

namespace Inc\Classes;

use Inc\Database\Db;
use Inc\Database\DbUser;

class User {

    public static function register($userName, $userEmail, $passwordHas) {
        $data = array("userName" => $userName, "userEmail" => $userEmail, "passwordHash" => $passwordHas, 'dateRegistration' => DbUser::now());
        return DbUser::insert($data);
    }

    public static function get($data, $type = "USERNAME") {
        if (!is_string($data)) return null;

        if ($type == "USERNAME") {
            $data = array("userName" => $data);
        } else if ($type == "USEREMAIL") {
            $data = array("userEmail" => $data);
        }

        $ret = DbUser::get($data)[0];
        return $ret;
    }

    public static function edit($data){
        $where = array('userName' => $_SESSION['user_name']);
        return DbUser::update($data, $where);
    }

    public static function getProfilePic($userName){
        $user = self::get($userName, $type = "USERNAME");
        if($user->idImage){

        }
    }

}