<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 14/01/2018
 * Time: 19:03
 */

namespace Inc\Utils;


use Inc\Base\BaseController;
use Inc\Database\DbCategory;
use Inc\Database\DbProduct;

class Product extends BaseController {


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
        if (isset($_POST['addProduct'])) {
            if ($id = $this->catchAdd()) {
                header("Location: $this->website_url/page.php?name=admin-area&product&edit&id=$id");
            } else {
                $this->errors[] = "Something's went wrong";
            }
            $this->showError();
        } else if (isset($_POST['updateProduct'])) {
            if ($id = $this->catchEdit()) {
                header("Location: $this->website_url/page.php?name=admin-area&product&edit&id=$id");
            } else {
                $this->errors[] = "Something's went wrong";
            }
            $this->showError();
        } else if (isset($_POST['deleteProduct'])) {
            if ($id = $this->catchDelete()) {
                header("Location: $this->website_url/page.php?name=admin-area&product");
            }
        }

    }


    /**
     * When clicked the button editAddress in edit-address.php
     * page the form send $_POST information and that function
     * permit to catch them.
     *
     * @return bool
     */
    public function catchAdd() {
        $title = $_POST['title'];
        $slug = empty($_POST['slug']) ?
            (str_replace(' ', '-', strtolower($title))) :
            (str_replace(' ', '-', strtolower($_POST['slug'])));
        $desc = $_POST['description'];
        $price = $_POST['price'];
        $available = $_POST['available'];
        $category = $_POST['category'];
        $image = $_FILES["image"];

        if (!(empty($title)) && $available) {

            $data = array(
                "slug" => $slug,
                "title" => $title,
                "description" => $desc,
                "price" => $price,
                "available" => $available ? true : false,
                "dateCreation" => DbProduct::now(),
                "dateLastUpdate" => DbProduct::now(),
                "idCategory" => $category,
            );

            // IMAGE
            if ($image['name']) {
                if ($idImage = Image::upload($image)) {
                    $data['idImage'] = $idImage;
                }
            }

            $existCategory = DbProduct::getSingle(["slug" => $slug], "OBJECT"); // Get the address
            // if exist
            if (!$existCategory) {
                return DbProduct::insert($data);

            } else {
                $this->errors[] = "The Product already exist, please change the slug";
                return false;
            }
        } else {
            $this->errors[] = "Insert title";
            return false;
        }
    }

    /**
     * When clicked the button editAddress in edit-address.php
     * page the form send $_POST information and that function
     * permit to catch them.
     *
     * @return bool
     */
    public function catchEdit() {
        $id = $_GET['id'];
        $title = $_POST['title'];
        $slug = empty($_POST['slug']) ?
            (str_replace(' ', '-', strtolower($title))) :
            (str_replace(' ', '-', strtolower($_POST['slug'])));
        $desc = $_POST['description'];
        $price = $_POST['price'];
        if (isset($_POST['available']) && $_POST['available'] == '1') {
            $available = 1;
        } else {
            $available = 0;
        }
        $category = $_POST['category'];
        $image = $_FILES["image"];
        $valid = null;

        if (!(empty($title))) {

            $data = array(
                "slug" => $slug,
                "title" => $title,
                "description" => $desc,
                "price" => $price,
                "available" => $available,
                "dateLastUpdate" => DbProduct::now(),
                "idCategory" => $category,
            );

            // IMAGE
            if ($image['name']) {
                if ($idImage = Image::upload($image)) {
                    $data['idImage'] = $idImage;
                }
            } else if (!(isset($_POST['image-exist']))) {
                $data['idImage'] = null;
            }

            $productToEdit = DbProduct::getSingle(["id" => $id], "OBJECT"); // Get the product from ID
            $productOfSlug = DbProduct::getSingle(["slug" => $slug], "OBJECT"); // Get the product from SLUG

            // if exist
            if ($productToEdit) {
                // check the slug
                if (!$productOfSlug) {
                    // no one have this slug
                    $valid = true;
                } else {
                    // only if is the same slug we can update it
                    if (($productOfSlug->id === $productToEdit->id)) {
                        $valid = true;
                    } else {
                        $this->errors[] = "Slug not available";
                        $valid = false;
                    }
                }

                if ($valid) {
                    return DbProduct::update($data, ["id" => $id]) ? $id : false;
                } else {
                    return false;
                }
            }
        } else {
            $this->errors[] = "Insert title";
            return false;
        }
    }

    public function catchDelete() {
        $id = $_GET['id'];
        return DbProduct::delete($id);
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
                $i = 0;
                foreach ($this->errors as $error) {
                    echo $error;
                    echo count($this->errors) != ++$i ? " - " : "";
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