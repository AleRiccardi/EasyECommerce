<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 13/01/2018
 * Time: 01:33
 */

namespace Inc\Admin;


use Inc\Base\BaseController;
use Inc\Classes\Image;
use Inc\Classes\User;
use Inc\Database\DbCategory;
use Inc\Database\DbImage;

class Category extends BaseController {



    public function register() {
        // in this case unless class
        if (isset($_GET['category'])) {

            if (isset($_GET['add-new'])) {
                $this->showAddNew();
            } else if(isset($_GET['edit']) && isset($_GET['id'])) {
                $this->showEdit($_GET['id']);
            } else {
                $this->getMain("Category");
            }

        }
    }


    public function showEdit($id) {
        $category = DbCategory::get(["id" => $id], "OBJECT");
        if(!$category){
            $this->getMain("Category");
            return;
        }
        $image = DbImage::get(['id' => $category->idImage], "OBJECT");

        if($image){
            $image = $this->website_url . $image->path;
        } else {
            $image = false;
        }
        ?>

        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
            <h2 class="admin-title">Edit category</h2>
            <form class="form-add-new" method="post" action="?name=admin-area&category&edit&id=<?php echo $category->id; ?>"
                  enctype="multipart/form-data"
                  name="edit-login-form">
                <div class="row row-offcanvas row-offcanvas-right">
                    <div class="col-12 col-md-9">
                        <input class="form-control form-control-lg" type="text" name="title"
                               placeholder="Insert title here" value="<?php echo $category->title; ?>">
                        <br>
                        <textarea class="form-control" name="description" rows="5"
                                  placeholder="Insert description"><?php echo $category->description; ?></textarea>
                        <br>
                        <p>
                            <small>Date creation:
                                <em><?php echo date("d M Y @ h:i:sa", strtotime($category->dateCreation)); ?></em></small>
                            <br>
                            <small>Last update:
                                <em><?php echo date("d M Y @ h:i:sa", strtotime($category->dateLastUpdate)); ?></em></small>
                        </p>
                    </div>

                    <div class="col-12 col-md-3" id="sidebar">
                        <div class="admin-sidebar-addnew ">
                            <input class="form-control" type="text" name="slug" placeholder="Slug"
                                   value="<?php echo $category->slug; ?>">
                            <br>
                            <div class="col-sm-12 admin-preview-img">
                                <img id="previewCat" class="img-cat <?php echo !$image ? "admin-hide" : "" ?>" src="<?php echo $image; ?>">
                                <label class="admin-btn-upload fileContainer">
                                    <label>Upload image</label>
                                    <input id="uploadImgCat" name="image" type="file" name="uploadIcon"/>
                                </label>
                                <label id="removeImgCat" class="admin-btn-remove <?php echo !$image ? "admin-hide" : "" ?>">Remove</label>
                            </div>
                            <br>
                            <br>
                            <button class="btn btn-primary btn-sm" name="updateCategory" type="submit">Update</button>
                            <button class="btn btn-danger btn-sm" name="deleteCategory" type="submit">Delete</button>
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
        $desc = isset($_POST['description']) ? $_POST['description'] : "";
        $image = isset($_POST['image']) ? $_POST['image'] : "";
        ?>
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
            <h2 class="admin-title">Add new</h2>
            <form class="form-add-new" method="post" action="?name=admin-area&category&add-new"
                  enctype="multipart/form-data"
                  name="edit-login-form">
                <div class="row row-offcanvas row-offcanvas-right">
                    <div class="col-12 col-md-9">
                        <input class="form-control form-control-lg" type="text" name="title"
                               placeholder="Insert title here" value="<?php echo $title; ?>">
                        <br>
                        <textarea class="form-control" name="description" rows="5"
                                  placeholder="Insert description"><?php echo $desc; ?></textarea>
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
                                    <input id="uploadImgCat" name="image" type="file" />
                                </label>
                                <label id="removeImgCat" class="admin-btn-remove admin-hide">Remove</label>
                            </div>
                            <br>
                            <br>
                            <button class="btn btn-primary btn-sm" name="addCategory" type="submit">Add</button>
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
        $categories = DbCategory::getAll("object");
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
                        <th>Description</th>
                        <th>Last update</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($categories) {
                        foreach ($categories as $category) { ?>
                            <tr onclick="window.location='?name=admin-area&category&edit&id=<?php echo $category->id; ?>';">
                                <td><?php echo $category->id; ?></td>
                                <td><?php echo $category->title; ?></td>
                                <td><?php echo $category->description; ?></td>
                                <td><?php echo $category->dateLastUpdate; ?></td>
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