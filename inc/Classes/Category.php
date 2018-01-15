<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 14/01/2018
 * Time: 19:03
 */

namespace Inc\Classes;


use Inc\Base\BaseController;
use Inc\Database\DbCategory;

class Category extends BaseController {

    public $title = "";
    public $slug = "";
    public $desc = "";
    public $image = "";

    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * Init function run form the Init class every
     * time that we load a page.
     */
    public function register() {
        if (isset($_POST['addCategory'])) {
            if($this->catchAddCategory()){
                $slug = $this->slug;
                //header("Location: $this->website_url/page.php?name=admin-area&category&slug=$slug");
            }
            $this->showError();
        }
    }


    /**
     * When clicked the button editAddress in edit-address.php
     * page the form send $_POST information and that function
     * permit to catch them.
     *
     * @return bool
     */
    public function catchAddCategory() {

        $user = User::getCurrentUser();

        $this->title = $_POST['title'];
        $this->slug = empty($_POST['slug']) ?
            (str_replace(' ', '-', strtolower($this->title))) :
            $_POST['slug'];
        $this->desc = $_POST['description'];
        $this->image = $_FILES["image"];

        if (!(empty($this->title))) {

            $data = array(
                "title" => $this->title,
                "description" => $this->desc,
                "slug" => $this->slug,
                "dateCreation" => DbCategory::now(),
                "dateLastUpdate" => DbCategory::now(),
            );

            // IMAGE
            if ($this->image['name']) {
                if($idImage = Image::upload($this->image)){
                    $data['idImage'] = $idImage;
                }
            }

            $existAddress = DbCategory::get(["slug" => $this->slug], "OBJECT"); // Get the address
            // if exist
            if (!$existAddress) {
                $this->messages[] = "Category inserted";
                return DbCategory::insert($data);

                /*$res = DbCategory::update($data, ["id" => $existAddress->id]);
                return $res ? true : false;*/
            } else {
                $this->errors[] = "The category already exist, please change the slug";
                return false;

                // if doesn't exist it will be create
                /*$idAddress = DbCategory::insert($data); // return the id of the row that is added
                $res = DbUser::update(["idAddress" => $idAddress], ["userName" => $user->userName]); // connect the address row with the user idAddress
                return $res ? true : false;*/
            }
        } else {
            $this->errors[] = "Insert title";
            return false;
        }
    }

    /**
     * simply return the current state of the user's login
     *
     * @return boolean user's login status
     */
    public function showError() {
        if ($this->errors) { ?>
            <div class="admin-message message alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php
                foreach ($this->errors as $error) {
                    echo $error;
                }
                ?>
            </div>
            <?php
        }
        if ($this->messages) { ?>
            <div class="admin-message message alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php
                foreach ($this->messages as $message) {
                    echo $message;
                }
                ?>
            </div>
            <?php
        }

    }

}