<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 16/01/2018
 * Time: 14:25
 */

namespace Inc\Base;


class DirController extends BaseController {
    const DIR_UPLOAD = "assets/upload/";
    const DIR_AVATAR = "assets/upload/avatar/";

    public $uploadPath = null;
    public $avatarPath = null;

    public function __construct() {
        $this->uploadPath = $this->website_path.self::DIR_UPLOAD;
        $this->avatarPath = $this->website_path.self::DIR_AVATAR;

        if(!file_exists($this->uploadPath)){
            mkdir($this->uploadPath);
        }
        if(!file_exists($this->avatarPath)){
            mkdir($this->avatarPath);
        }
    }

}