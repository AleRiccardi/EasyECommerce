<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 07/01/2018
 * Time: 04:54
 */

namespace Inc\Classes;

use Inc\Base\BaseController;
use Inc\Database\DbImage;
use Inc\Database\DbUser;

class User {

    public function register() {
        self::editUser();
    }

    public static function registration($userName, $userEmail, $passwordHas) {
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
        $data = array("idImage" => null);

        $user = self::getByNameEmail($id, $type);

        $where = array('id' => $user->id);
        if (!(DbUser::update($data, $where))) {
            return false;
        }

        if (!(Image::removeById($user->idImage))) {
            return false;
        }

        return true;
    }

    public static function editUser() {
        if (isset($_POST['editLogin'])) {

            $data = array(
                "firstName" => $_POST['firstName'],
                "secondName" => $_POST['secondName'],
            );

            // PASSWORD
            $user_password = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : null;
            if ($user_password) {
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);
                $data['passwordHash'] = $user_password_hash;
            }

            // FILE
            if ($_FILES["uploadIcon"]['name']) {
                $idImage = Image::upload($_SESSION['user_name'], $_FILES['uploadIcon']);
                $data['idImage'] = $idImage;
            }

            return DbUser::update($data, ["userName" => $_SESSION['user_name']]);
        } else if (isset($_POST["removeImage"])) {

            return self::removeImage($_SESSION["user_name"]);
        }
        // default
        return false;
    }


}