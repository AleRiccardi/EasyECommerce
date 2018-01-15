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
    public function getAddNew() { ?>
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
            <h1 class="admin-title">Add new</h1>
            <form class="form-add-new" method="post" action="?name=admin-area&category" enctype="multipart/form-data"
                  name="edit-login-form">
                <div class="row row-offcanvas row-offcanvas-right">
                    <div class="col-12 col-md-9">
                        <input class="form-control form-control-lg" type="text" id="title"
                               placeholder="Insert title here">
                        <br>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                  placeholder="Insert description"></textarea>
                        <br>
                        <p>
                            <small>Date creation: <em>10 Oct 2017</em></small>
                            <br>
                            <small>Last update: <em>15 Oct 2017</em></small>
                        </p>
                    </div>

                    <div class="admin-sidebar-addnew col-6 col-md-3 sidebar-offcanvas " id="sidebar">
                        <input class="form-control" type="text" id="slug" placeholder="Slug">
                        <br>
                        <div class="col-sm-12 admin-category-img">
                            <img id="previewCat" src="">
                            <label class="admin-btn-load fileContainer">
                                Upload image
                                <input id="uploadImgCat" type="file" name="uploadIcon"/>
                            </label>
                        </div>

                    </div>

                </div>


                <button class="btn btn-primary" name="addCategory" type="submit">Add</button>
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