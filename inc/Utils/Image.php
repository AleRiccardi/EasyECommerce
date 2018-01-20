<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 09/01/2018
 * Time: 02:15
 */

namespace Inc\Utils;


use Inc\Base\BaseController;
use Inc\Base\DirController;
use Inc\Database\Db;
use Inc\Database\DbImage;

class Image {

    const MAX_SIZE = 5000000;

    /**
     * @param $userName
     * @param $file
     *
     * @return bool|int|null
     */
    public static function uploadProfile($userName, $file) {
        $baseC = new BaseController();

        $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $relativePath = DirController::DIR_AVATAR . strtolower($userName) . "-avatar.$imageFileType";
        $target_file = $baseC->website_path . $relativePath;

        $uploadOk = 1;
        // Check if image file is a actual image or fake image
        if (isset($_POST["edit-login"])) {
            $check = getimagesize($file["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check file size
        if ($file["size"] > self::MAX_SIZE) {
            echo "Sorry, your file is too large: " . $file["size"];
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                $uploadOk = 1;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        if ($uploadOk) {
            $idImage = DbImage::insert($relativePath);
            return $idImage;
        }
    }

    /**
     * @param $userName
     * @param $file
     *
     * @return bool|int|null
     */
    public static function upload($file) {
        $baseController = new BaseController();

        $target_dir = "/assets/uploads/2018/";
        $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $relativePath = $target_dir . basename($file["name"]);
        $target_file = $baseController->website_path . $relativePath;

        $uploadOk = 1;
        // Check if image file is a actual image or fake image
        if (isset($_POST["edit-login"])) {
            $check = getimagesize($file["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check file size
        if ($file["size"] > self::MAX_SIZE) {
            echo "Sorry, your file is too large: " . $file["size"];
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                $uploadOk = 1;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }


        if ($uploadOk) {
            $idImage = DbImage::insert($relativePath);
            return $idImage;
        }
        // default
        return false;
    }


    public static function removeById($id) {
        return DbImage::delete($id);
    }

}