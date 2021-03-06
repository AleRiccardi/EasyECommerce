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
use Inc\Database\DbImage;
use Inc\Database\DbItem;

class Item extends BaseController {


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
        $available = 1;
        $category = $_POST['category'];
        $image = $_FILES["image"];

        if (!(empty($title)) && $available) {

            $data = array(
                "slug" => $slug,
                "title" => $title,
                "description" => $desc,
                "price" => $price,
                "available" => 1,
                "dateCreation" => DbItem::now(),
                "dateLastUpdate" => DbItem::now(),
                "idCategory" => $category,
            );

            // IMAGE
            if ($image['name']) {
                if ($idImage = Image::upload($image)) {
                    $data['idImage'] = $idImage;
                }
            }

            $existCategory = DbItem::getSingle(["slug" => $slug], "OBJECT"); // Get the address
            // if exist
            if (!$existCategory) {
                return DbItem::insert($data);

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
        $available = 1;
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
                "dateLastUpdate" => DbItem::now(),
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

            $productToEdit = DbItem::getSingle(["id" => $id], "OBJECT"); // Get the product from ID
            $productOfSlug = DbItem::getSingle(["slug" => $slug], "OBJECT"); // Get the product from SLUG

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
                    return DbItem::update($data, ["id" => $id]) ? $id : false;
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
        return DbItem::update(["available" => 0], ["id" => $id]);
    }


    public static function getHTMLFiltredItems($idCategory, $date, $price, $title) {
        $baseC = new BaseController();
        $filter = array();
        if($date == 1) $filter["dateCreation"] = "ASC";
        else if($date == 2) $filter["dateCreation"] = "DESC";

        if($price == 1) $filter["price"] = "ASC";
        else if($price == 2) $filter["price"] = "DESC";

        if($title == 1) $filter["title"] = "ASC";
        else if($title == 2) $filter["title"] = "DESC";

        $where = [
            "idCategory" => $idCategory,
        ];

        // current items
        $items = DbItem::getFiltered($filter, $where, "object");

        ?>
        <!-- Items Masonry -->
        <div class="grid row">

            <div class="grid-sizer col-xs-6 col-sm-4 col-md-4">

            </div>
            <?php
            $i = 0;
            foreach ($items as $item) {
                $image = DbImage::getSingle(["id" => $item->idImage], 'object');
                $imagePath = $image ? $image->path : "/assets/img/no-image.jpg";
                ?>
                <div class="grid-item col-xs-6 col-sm-4 col-md-4">
                    <div class="card">
                        <img class="card-img-top"
                             src="<?php echo $baseC->website_url . $imagePath ?>"
                             alt="<?php echo $item->title ?>">
                        <div class="card-body">
                            <h5 class="card-title">
                                            <span class="title-prod" data-prod-id='<?php echo $item->id ?>'>
                                                <?php echo $item->title ?>
                                            </span>
                                <span class="badge badge-secondary">€
                                    <?php echo $item->price ?>
                                            </span>
                            </h5>
                            <p class="card-text"><?php echo $item->description ?></p>
                        </div>
                        <div class="card-footer">
                            <div style="float: left; display: inline-block">
                                <div class="cont-input-number">
                                    <span class="input-number-decrement">–</span>
                                    <input class="input-number" type="text" value="1" min="1" max="30"
                                           data-prod-id='<?php echo $item->id ?>'>
                                    <span class="input-number-increment">+</span>
                                </div>
                            </div>
                            <div style="float: left; margin-left: 15px; display: inline-block">
                                <button type="button" class="btn btn-success btn-sm btn-add"
                                        data-prod-id='<?php echo $item->id ?>'>
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
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