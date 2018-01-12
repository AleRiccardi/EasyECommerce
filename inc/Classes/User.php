<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 07/01/2018
 * Time: 04:54
 */

namespace Inc\Classes;

use Inc\Base\BaseController;
use Inc\Database\Db;
use Inc\Database\DbImage;
use Inc\Database\DbUser;

class User {

    public static function register($userName, $userEmail, $passwordHas) {
        $data = array("userName" => $userName, "userEmail" => $userEmail, "passwordHash" => $passwordHas, 'dateRegistration' => DbUser::now());
        return DbUser::insert($data);
    }

    public static function getByNameEmail($id, $type = "USERNAME") {
        if (!is_string($id)) return null;

        if ($type == "USERNAME") {
            $data = array("userName" => $id);
        } else if ($type == "USEREMAIL") {
            $data = array("userEmail" => $id);
        }

        $ret = DbUser::get($data);
        return $ret;
    }

    public static function edit($data, $userName) {
        $where = array('userName' => $userName);
        return DbUser::update($data, $where);
    }

    public static function getProfilePic($userName) {
        $imageFinalPath = null;
        $baseController = new BaseController();
        $user = self::getByNameEmail($userName, $type = "USERNAME");
        if ($user->idImage) {
            // get row from Image table
            $image = DbImage::get(array("id" => $user->idImage));
            if ($image) {
                $imageFinalPath = $baseController->website_url . $image->path;
            } else {
                $imageFinalPath = $baseController->website_url . "/assets/img/icon/default-avatar.png";
            }
        } else {
            $imageFinalPath = $baseController->website_url . "/assets/img/icon/default-avatar.png";
        }

        // Append a query string with an arbitrary unique number to
        // force the browser to refresh the image.
        $imageFinalPath .= "?" . rand(1, 500000000);

        return $imageFinalPath;
    }

    public static function removeImage($id, $type = "USERNAME") {
        if (!is_string($id)) return null;
        $data = array("idImage" => NULL);

        $user = self::getByNameEmail($id, $type);

        $where = array('id' => $user->id);
        if (!(DbUser::update($data, $where))) {
            echo "update user";
            return false;
        }

        if (!(Image::removeById($user->idImage))) {
            echo "remove image";
            return false;
        }

        return true;
    }

}