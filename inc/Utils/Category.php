<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 14/01/2018
 * Time: 19:03
 */

namespace Inc\Utils;


use Inc\Base\BaseController;
use Inc\Base\DirController;
use Inc\Database\DbCategory;

class Category extends BaseController {


    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * Init function run form the Init class every time that we load
     * a page. Here were always attending that a form submit a form.
     */
    public function register() {
        $dirC = new DirController();


        if (isset($_POST['addCategory'])) {
            if ($id = $this->catchAdd()) {
                header("Location: $this->website_url/page.php?name=admin-area&category&edit&id=$id");
            }
            $this->showError();
        } else if (isset($_POST['updateCategory'])) {
            if ($id = $this->catchEdit()) {
                header("Location: $this->website_url/page.php?name=admin-area&category&edit&id=$id");
            }
            $this->showError();
        } else if (isset($_POST['deleteCategory'])) {
            if ($id = $this->catchDelete()) {
                header("Location: $this->website_url/page.php?name=admin-area&category");
            }
            $this->showError();
        }

    }

    /**
     * Catch all the information submitted from the form
     * that create (add) the category.
     *
     * @return false|int the number of the category updated,
     *                   false if errors.
     */
    public function catchAdd() {
        $title = $_POST['title'];
        $slug = empty($_POST['slug']) ?
            (str_replace(' ', '-', strtolower($title))) :
            (str_replace(' ', '-', strtolower($_POST['slug'])));
        $desc = $_POST['description'];
        $image = $_FILES["image"];

        if (!(empty($title))) {

            $data = array(
                "title" => $title,
                "description" => $desc,
                "slug" => $slug,
                "dateCreation" => DbCategory::now(),
                "dateLastUpdate" => DbCategory::now(),
            );

            // IMAGE
            if ($image['name']) {
                if ($idImage = Image::upload($image)) {
                    $data['idImage'] = $idImage;
                }
            }

            $existCategory = DbCategory::getSingle(["slug" => $slug], "OBJECT"); // Get the address
            // if exist
            if (!$existCategory) {
                $messages[] = "Category inserted";
                return DbCategory::insert($data);

            } else {
                $this->errors[] = "The category already exist, please change the slug";
                return false;
            }
        } else {
            $this->errors[] = "Insert title";
            return false;
        }
    }

    /**
     * Catch all the information submitted from the form
     * that edit the category.
     *
     * @return false|int the number of the category updated,
     *                   false if errors.
     */
    public function catchEdit() {
        $id = $_GET['id'];
        $title = $_POST['title'];
        $slug = empty($_POST['slug']) ?
            (str_replace(' ', '-', strtolower($title))) :
            (str_replace(' ', '-', strtolower($_POST['slug'])));
        $desc = $_POST['description'];
        $image = $_FILES["image"];
        $valid = null;

        if (!(empty($title))) {

            $data = array(
                "title" => $title,
                "description" => $desc,
                "slug" => $slug,
                "dateLastUpdate" => DbCategory::now(),
            );

            // IMAGE
            if ($image['name']) {
                if ($idImage = Image::upload($image)) {
                    $data['idImage'] = $idImage;
                }
            } else if (!(isset($_POST['image-exist']))) {
                $data['idImage'] = null;
            }

            $categoryToEdit = DbCategory::getSingle(["id" => $id], "OBJECT"); // Get the category from ID
            $categoryOfSlug = DbCategory::getSingle(["slug" => $slug], "OBJECT"); // Get the category from SLUG

            // if exist
            if ($categoryToEdit) {
                // check the slug
                if (!$categoryOfSlug) {
                    // no one have this slug
                    $valid = true;
                } else {
                    // only if is the same slug we can update it
                    if (($categoryOfSlug->id === $categoryToEdit->id)) {
                        $valid = true;
                    } else {
                        $this->errors[] = "Slug not available";
                        $valid = false;
                    }
                }

                if ($valid) {
                    $messages[] = "Category inserted";
                    return DbCategory::update($data, ["id" => $id]) ? $id : false;
                } else {
                    return false;
                }
            }
        } else {
            $this->errors[] = "Insert title";
            return false;
        }
    }

    /**
     * Catch when we want to delete a category.
     *
     * @return bool ture if success, false if errors.
     */
    public function catchDelete() {
        $id = $_GET['id'];
        $res = DbCategory::delete($id);
        if ($res === null) {
            // trying to delete default
            $this->errors[] = "You're trying to delete the default category. It is not 
                                possible if you don't remove before that category to all your products.";
            return false;
        } else if ($res === false) {
            // errors
            return false;
        } else if ($res === true) {
            // success
            return true;
        }

        // default
        return false;
    }

    /**
     * Simply return the error and success that we store in the
     * two variable $errors and $messages.
     */
    public function showError() {
        if ($this->errors) { ?>
            <div class="admin-message message alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php
                foreach ($this->errors as $error) {
                    echo $error . " ";
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