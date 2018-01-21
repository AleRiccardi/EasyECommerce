<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 16/01/2018
 * Time: 14:25
 */

namespace Inc\Base;


class DirController extends BaseController {
    const DIR_UPLOAD = "/assets/upload/";
    const DIR_AVATAR = "/assets/upload/avatar/";
    const DIR_IMG = "/assets/img/";
    const DIR_ICON = "/assets/img/icon/";

    public $uploadPath = null;
    public $uploadUrl = null;
    public $avatarPath = null;
    public $avatarUrl = null;
    public $imgPath = null;
    public $imgUrl = null;
    public $iconPath = null;
    public $iconUrl = null;

    public function __construct() {
        parent::__construct();

        $this->uploadPath = $this->website_path.self::DIR_UPLOAD;
        $this->uploadUrl = $this->website_url.self::DIR_UPLOAD;
        $this->avatarPath = $this->website_path.self::DIR_AVATAR;
        $this->avatarUrl = $this->website_url.self::DIR_AVATAR;
        $this->imgPath = $this->website_path.self::DIR_IMG;
        $this->imgUrl = $this->website_url.self::DIR_IMG;
        $this->iconPath = $this->website_path.self::DIR_ICON;
        $this->iconUrl = $this->website_url.self::DIR_ICON;

        if(!file_exists($this->uploadPath)){
            mkdir($this->uploadPath);
        }
        if(!file_exists($this->avatarPath)){
            mkdir($this->avatarPath);
        }
    }

}