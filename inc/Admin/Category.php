<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 13/01/2018
 * Time: 01:33
 */

namespace Inc\Admin;


use Inc\Classes\User;

class Category {

    public $idCategory = null;
    private $isAddNew = false;


    public function register() {
        // in this case unless class
        if (!isset($_GET['category'])) {
            return false;
        } else {
            $this->isAddNew = isset($_GET['add-new']) ? true : false;
            // what we matters
            $this->idCategory = $_GET['category'];

            if ($this->idCategory == "") {

                if (!$this->isAddNew) {
                    $this->showDashboard();
                } else {
                    $this->showAddNew();
                }
            } else {
                // show specific cat
                $this->showSpecificCategory($this->idCategory);
            }
        }
    }

    public function showDashboard() {
        $this->getMain("Category");
    }

    public function showAddNew() {
        $this->getAddNew();
    }


    public function showSpecificCategory($name) { ?>
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
            <h1 class="admin-title"><?php echo $name; ?></h1>
        </main>
        <?php
    }


    /**
     *
     */
    public function getAddNew() {
        $title = isset($_POST['title']) ? $_POST['title'] : "";
        $slug = empty($_POST['slug']) ?
            (str_replace(' ', '-', strtolower($title))) :
            $_POST['slug'];
        $desc = isset($_POST['description']) ? $_POST['description'] : "";
        $image = isset($_POST['image']) ? $_POST['image'] : "";
        ?>
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
            <h1 class="admin-title">Add new</h1>
            <form class="form-add-new" method="post" action="?name=admin-area&category&add-new" enctype="multipart/form-data"
                  name="edit-login-form">
                <div class="row row-offcanvas row-offcanvas-right">
                    <div class="col-12 col-md-9">
                        <input class="form-control form-control-lg" type="text" name="title"
                               placeholder="Insert title here" value="<?php echo $title; ?>">
                        <br>
                        <textarea class="form-control" name="description" rows="5"
                                  placeholder="Insert description"><?php echo $desc; ?></textarea>
                        <br>
                        <p>
                            <small>Date creation: <em>10 Oct 2017</em></small>
                            <br>
                            <small>Last update: <em>15 Oct 2017</em></small>
                        </p>
                        <button class="btn btn-primary" name="addCategory" type="submit">Add</button>
                    </div>

                    <div class="col-6 col-md-3" id="sidebar">
                        <div class="admin-sidebar-addnew ">
                            <input class="form-control" type="text" name="slug" placeholder="Slug" value="<?php echo $slug; ?>">
                            <br>
                            <div class="col-sm-12 admin-category-img">
                                <img id="previewCat" class="img-cat admin-hide" src="<?php echo $image; ?>">
                                <label class="admin-btn-upload fileContainer">
                                    <label>Upload image</label>
                                    <input id="uploadImgCat" name="image" type="file" name="uploadIcon"/>
                                </label>
                                <label id="removeImgCat" class="admin-btn-remove admin-hide">Remove</label>
                            </div>
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
    public function getMain($name) { ?>
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
            <h1 class="admin-title"><?php echo $name; ?></h1>
            <h4>List categories</h4>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Header</th>
                        <th>Header</th>
                        <th>Header</th>
                        <th>Header</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1,001</td>
                        <td>Lorem</td>
                        <td>ipsum</td>
                        <td>dolor</td>
                        <td>sit</td>
                    </tr>
                    <tr>
                        <td>1,002</td>
                        <td>amet</td>
                        <td>consectetur</td>
                        <td>adipiscing</td>
                        <td>elit</td>
                    </tr>
                    </tbody>
                </table>
        </main>
        <?php
    }
}