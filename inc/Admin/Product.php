<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 13/01/2018
 * Time: 01:33
 */

namespace Inc\Admin;


use Inc\Base\BaseController;
use Inc\Database\DbCategory;
use Inc\Database\DbImage;
use Inc\Database\DbProduct;

class Product extends BaseController {


    public function register() {
        // in this case unless class
        if (isset($_GET['product'])) {

            if (isset($_GET['add-new'])) {
                $this->showAddNew();
            } else if (isset($_GET['edit']) && isset($_GET['id'])) {
                $this->showEdit($_GET['id']);
            } else {
                $this->getMain("Product");
            }

        }
    }


    public function showEdit($id) {
        $product = DbProduct::getSingle(["id" => $id], "OBJECT");
        if (!$product) {
            $this->getMain("Category");
            return;
        }
        $image = DbImage::getSingle(['id' => $product->idImage], "OBJECT");

        if ($image) {
            $image = $this->website_url . $image->path;
        } else {
            $image = false;
        }
        ?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
            <h2 class="admin-title">Edit product</h2>
            <form class="form-add-new" method="post"
                  action="?name=admin-area&product&edit&id=<?php echo $product->id; ?>"
                  enctype="multipart/form-data"
                  name="edit-login-form">
                <div class="row row-offcanvas row-offcanvas-right">
                    <div class="col-12 col-md-9">
                        <input class="form-control form-control-lg" type="text" name="title"
                               placeholder="Insert title here" value="<?php echo $product->title; ?>">
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <input name="price" class="form-control form-control-sm" type="number" step="any"
                                       min="0.1"
                                       placeholder="Price" value="<?php echo $product->price; ?>" required>
                            </div>
                            <div class="form-group col-md-5">
                                <select name="category" class="form-control form-control-sm" required>
                                    <option value="">Category...</option>
                                    <?php
                                    $categories = DbCategory::getAll('object');
                                    foreach ($categories as $category) {
                                        if ($product->idCategory === $category->id) {
                                            echo "<option value='$category->id' selected>$category->title</option>";
                                        } else {
                                            echo "<option value='$category->id'>$category->title</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="form-check">
                                    <input name="available" class="form-check-input" type="checkbox"
                                           value="1" <?php echo $product->available ? "checked" : "" ?>>
                                    <label class="form-check-label" for="defaultCheck1">
                                        Available
                                    </label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <textarea class="form-control" name="description" rows="5"
                                  placeholder="Insert description"><?php echo $product->description; ?></textarea>
                        <br>
                        <p>
                            <small>Date creation:
                                <em><?php echo date("d M Y @ h:i:sa", strtotime($product->dateCreation)); ?></em>
                            </small>
                            <br>
                            <small>Last update:
                                <em><?php echo date("d M Y @ h:i:sa", strtotime($product->dateLastUpdate)); ?></em>
                            </small>
                        </p>
                    </div>

                    <div class="col-12 col-md-3" id="sidebar">
                        <div class="admin-sidebar-addnew ">
                            <input class="form-control" type="text" name="slug" placeholder="Slug"
                                   value="<?php echo $product->slug; ?>">
                            <br>
                            <div class="col-sm-12 admin-preview-img">
                                <img id="previewCat" class="img-cat <?php echo !$image ? "admin-hide" : "" ?>"
                                     src="<?php echo $image; ?>">
                                <label class="admin-btn-upload fileContainer">
                                    <label>Upload image</label>
                                    <input id="uploadImgCat" name="image" type="file" accept=".jpg, .jpeg, .png"/>
                                    <?php echo $image ? '<input class="admin-hide" name="image-exist" id="image-exist"/>' : ""; ?>
                                </label>
                                <label id="removeImgCat"
                                       class="admin-btn-remove <?php echo !$image ? "admin-hide" : "" ?>">Remove</label>
                            </div>
                            <br>
                            <br>
                            <button class="btn btn-primary btn-sm" name="updateProduct" type="submit">Update</button>
                            <button class="btn btn-danger btn-sm" name="deleteProduct" type="submit">Delete</button>
                        </div>
                    </div>

                </div>
            </form>
        </main>
        <?php
    }


    /**
     *
     */
    public function showAddNew() {
        $title = isset($_POST['title']) ? $_POST['title'] : "";
        $slug = empty($_POST['slug']) ?
            (str_replace(' ', '-', strtolower($title))) :
            $_POST['slug'];
        $price = isset($_POST['price']) ? $_POST['price'] : "";
        $desc = isset($_POST['description']) ? $_POST['description'] : "";
        $image = isset($_POST['image']) ? $_POST['image'] : "";
        ?>
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
            <h2 class="admin-title">Add new</h2>
            <form class="form-add-new" method="post" action="?name=admin-area&product&add-new"
                  enctype="multipart/form-data"
                  name="edit-login-form">
                <div class="row row-offcanvas row-offcanvas-right">
                    <div class="col-12 col-md-9">
                        <input name="title" class="form-control form-control-lg" type="text"
                               placeholder="Insert title here" value="<?php echo $title; ?>" required>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <input name="price" class="form-control form-control-sm" type="number" step="any"
                                       min="0.1"
                                       placeholder="Price" value="<?php echo $price; ?>" required>
                            </div>
                            <div class="form-group col-md-5">
                                <select name="category" class="form-control form-control-sm" required>
                                    <option value="">Category...</option>
                                    <?php
                                    $categories = DbCategory::getAll('object');
                                    foreach ($categories as $category) {
                                        echo "<option value='$category->id'>$category->title</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="form-check">
                                    <input name="available" class="form-check-input" type="checkbox" value="1" checked>
                                    <label class="form-check-label" for="defaultCheck1">
                                        Available
                                    </label>
                                </div>
                            </div>
                        </div>

                        <br>
                        <textarea name="description" class="form-control" rows="5"
                                  placeholder="Insert description"><?php echo $desc; ?></textarea>
                        <br>
                    </div>

                    <div class="col-6 col-md-3" id="sidebar">
                        <div class="admin-sidebar-addnew ">
                            <input class="form-control" type="text" name="slug" placeholder="Slug"
                                   value="<?php echo $slug; ?>">
                            <br>
                            <div class="col-sm-12 admin-preview-img">
                                <img id="previewCat" class="img-cat admin-hide" src="<?php echo $image; ?>">
                                <label class="admin-btn-upload fileContainer">
                                    <label>Upload image</label>
                                    <input id="uploadImgCat" name="image" type="file" accept=".jpg, .jpeg, .png"/>
                                </label>
                                <label id="removeImgCat" class="admin-btn-remove admin-hide">Remove</label>
                            </div>
                            <br>
                            <br>
                            <button class="btn btn-primary btn-sm" name="addProduct" type="submit">Add</button>
                        </div>

                    </div>

                </div>

            </form>
        </main>
        <?php
    }

    /**
     * @param $name
     */
    public function getMain($name) {
        $products = DbProduct::getAll("object");

        ?>
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
            <h1 class="admin-title"><?php echo $name; ?></h1>
            <h4>List categories</h4>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>n°</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Available</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Last update</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($products) {
                        foreach ($products as $product) {
                            $category = DbCategory::getSingle(['id' => $product->idCategory], 'object');
                            $max_length = 40;
                            $desc = $product->description;

                            if (strlen($desc) > $max_length)
                            {
                                $offset = ($max_length - 3) - strlen($desc);
                                $desc = substr($desc, 0, strrpos($desc, ' ', $offset)) . '...';
                            }
                            ?>

                            <tr onclick="window.location='?name=admin-area&product&edit&id=<?php echo $product->id; ?>';">
                                <td><?php echo $product->id; ?></td>
                                <td><?php echo $product->title; ?></td>
                                <td><?php echo $product->price; ?></td>
                                <td><?php echo $product->available ? 1 : 0; ?></td>
                                <td><a href="?name=admin-area&category&edit&id=<?php echo $category->id; ?>"><?php echo $category->title; ?></a></td>
                                <td><?php echo $desc; ?></td>

                                <td><?php echo $product->dateLastUpdate; ?></td>
                            </tr>
                            <?php
                        }
                    } ?>
                    </tbody>
                </table>
        </main>
        <?php
    }
}