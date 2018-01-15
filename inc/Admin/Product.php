<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 13/01/2018
 * Time: 01:33
 */

namespace Inc\Admin;


class Product {

    public $idProduct = null;
    private $isAddNew = false;

    public function register() {
        // in this case unless class
        if (!isset($_GET['product'])) {
            return false;
        } else {
            $this->isAddNew = isset($_GET['add-new']) ? true : false;
            // what we matters
            $this->idProduct = $_GET['product'];

            if ($this->idProduct == "") {
                //show overview
                if(!$this->isAddNew){
                    $this->showDashboard();
                } else {
                    $this->addNew();
                }

            } else {
                // show specific cat
                $this->showSpecific($this->idCategory);
            }
        }
    }

    public function showDashboard() {
        $this->getMain("Products");
    }

    public function showSpecific($name) { ?>
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
            <h1 class="admin-title"><?php echo $name; ?></h1>
        </main>
        <?php
    }


    public function getMain($name) { ?>
        <main role="main" class="col-sm-9 ml-sm-auto col-md-10 pt-3">
            <h1 class="admin-title"><?php echo $name; ?></h1>
            <h4>List products</h4>
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