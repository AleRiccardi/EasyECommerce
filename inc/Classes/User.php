<?php

namespace Inc\Classes;

use Inc\Base\BaseController;
use Inc\Database\DbImage;
use Inc\Database\DbUser;

/**
 * Class User
 *
 * @package Inc\Classes
 */
class User {

    /**
     * Init function run form the Init class every
     * time that we load a page.
     */
    public function register() {
        self::editUser();
    }

    /**
     * Register a new user.
     *
     * @param string $userName     username
     * @param string $userEmail    email address
     * @param string $passwordHash password
     *
     * @return bool|int id of the row if everything right, false otherwise
     */
    public static function registerNewUser($userName, $userEmail, $passwordHash) {
        $data = array(
            "userName" => $userName,
            "userEmail" => $userEmail,
            "passwordHash" => $passwordHash,
            'dateRegistration' => DbUser::now()
        );
        return DbUser::insert($data);
    }

    /**
     * Get the current user logged.
     *
     * @return array|null
     */
    public static function getCurrentUser() {
        if(isset($_SESSION['userName'])) {
            return self::getBy($_SESSION['userName'], "USERNAME");
        } else {
            return false;
        }
    }

    /**
     * Understand if the user is admin or not.
     *
     * @return bool true if is admin, false if not
     */
    public static function isAdmin() {
        if($user = self::getCurrentUser()) {
            return $user->isAdmin ? true : false;
        } else {
            return false;
        }
    }



    /**
     * Get user from username or email address.
     *
     * @param        $id   the username or email
     * @param string $type USERNAME | USEREMAIL
     *
     * @return array|object|null
     */
    public static function getBy($id, $type = "USERNAME") {
        if (!is_string($id)) return null;
        $data = null;
        if ($type == "USERNAME") {
            $data = array("userName" => $id);
        } else if ($type == "USEREMAIL") {
            $data = array("userEmail" => $id);
        }

        $ret = DbUser::getSingle($data, "OBJECT");
        return $ret;
    }

    /**
     * Get the profile pic of a user.
     *
     * @param string $userName the username
     *
     * @return null|string the url of the img
     */
    public static function getProfilePic($userName) {
        $imageFinalPath = null;
        $baseController = new BaseController();
        $user = self::getBy($userName, $type = "USERNAME");

        if ($user && $user->idImage) {
            // get row from Image table
            $image = DbImage::getSingle(array("id" => $user->idImage), "OBJECT");
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

    /**
     *  Remove image of a specific user.
     *
     * @param string $id   the username or email
     * @param string $type USERNAME | USEREMAIL
     *
     * @return bool true if success, false otherwise
     */
    public static function removeImage($id, $type = "USERNAME") {
        if (!is_string($id)) return false;
        $data = array("idImage" => null);

        $user = self::getBy($id, $type);

        $where = array('id' => $user->id);
        if (!(DbUser::update($data, $where))) {
            return false;
        }

        if (!(Image::removeById($user->idImage))) {
            return false;
        }

        return true;
    }

    /**
     * When clicked the button editLogin||removeImage  in edit-user.php
     * page the form send $_POST information and that function permit to
     * catch them.
     *
     * @return bool|false|int
     */
    public static function editUser() {
        if (isset($_POST['editLogin'])) {

            $data = array(
                "firstName" => $_POST['firstName'],
                "secondName" => $_POST['secondName'],
            );

            // PASSWORD
            $userPassword = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : null;
            if ($userPassword) {
                $userPassword_hash = password_hash($userPassword, PASSWORD_DEFAULT);
                $data['passwordHash'] = $userPassword_hash;
            }

            // FILE
            if ($_FILES["uploadIcon"]['name']) {
                $idImage = Image::uploadProfile($_SESSION['userName'], $_FILES['uploadIcon']);
                $data['idImage'] = $idImage;
            }

            return DbUser::update($data, ["userName" => $_SESSION['userName']]);
        } else if (isset($_POST["removeImage"])) {

            return self::removeImage($_SESSION["userName"]);
        }
        // default
        return false;
    }


}