<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 12/01/2018
 * Time: 18:34
 */

namespace Inc\Admin;


class AdminEngine {
    const SLUG_OVERVIEW = "overview";
    const SLUG_CATEGORY = "category";
    const SLUG_PRODUCT = "product";

    // page overview
    private $isOverview = false;
    private $nameOverview = false;
    // page categories
    private $isCategories = false;
    private $nameCategory = null;
    // page products
    private $isProducts = false;
    private $nameProduct = null;

    private $isAddNew = false;

    private $overviewTemp = null;
    private $categoryTemp = null;
    private $productTemp = null;


    public function __construct() {
        $this->overviewTemp = new Overview();
        $this->categoryTemp = new Category();
        $this->productTemp = new Product();

        $this->register();
    }

    /**
     * Init function run form the Init class every
     * time that we load a page.
     */
    public function register() { ?>
        <main role="main">
            <div class="container-fluid">
                <div class="row">
                    <?php $this->getMain(); ?>
                </div>
            </div>
        </main>
        <?php
    }

    private function getMain() {
        $this->isAddNew = isset($_GET['add-new']) ? true : false;

        if (isset($_GET[self::SLUG_OVERVIEW])) {
            // OVERVIEW
            $this->isOverview = true;
            $this->nameOverview = !empty($_GET[self::SLUG_OVERVIEW]) ?
                $_GET[self::SLUG_OVERVIEW] : null;
            $this->getSidebar();

            $this->overviewTemp->register();

        } else if (isset($_GET[self::SLUG_CATEGORY])) {
            // CATEGORY
            $this->isCategories = true;
            $this->nameCategory = !empty($_GET[self::SLUG_CATEGORY]) ?
                $_GET[self::SLUG_CATEGORY] : null;
            $this->getSidebar();
            $this->categoryTemp->register();


        } else if (isset($_GET[self::SLUG_PRODUCT])) {
            // PRODUCT
            $this->isProducts = true;
            $this->nameProduct = !empty($_GET[self::SLUG_PRODUCT]) ?
                $_GET[self::SLUG_PRODUCT] : null;
            $this->getSidebar();
            $this->productTemp->register();

        } else {

        }

    }


    private function getSidebar() { ?>
        <nav class="col-sm-3 col-md-2 d-none d-sm-block bg-light admin-sidebar">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <?php if ($this->isOverview) { ?>
                        <a class="nav-link active" href="?name=admin-area&overview">Overview<span
                                    class="sr-only">(current)</span></a>
                    <?php } else { ?>
                        <a class="nav-link" href="?name=admin-area&overview">Overview</a>
                    <?php } ?>
                </li>
                <li class="nav-item">
                    <?php if ($this->isCategories) { ?>
                        <a class="nav-link active" href="?name=admin-area&category">Category <span
                                    class="sr-only">(current)</span></a>
                        <ul class="admin-sub-menu">
                            <li class="">
                                <a href="?name=admin-area&category"><?php
                                    echo !$this->isAddNew ?
                                        "<b>All Categories</b>" :
                                        "All Categories";
                                    ?>
                                </a>
                            </li>
                            <li>
                                <a href="?name=admin-area&category&add-new"><?php
                                    echo $this->isAddNew ?
                                        "<b>Add New</b>" :
                                        "Add New";
                                    ?></a>
                            </li>
                        </ul>
                    <?php } else { ?>
                        <a class="nav-link" href="?name=admin-area&category">Category</a>

                    <?php } ?>
                </li>
                <li class="nav-item">
                    <?php if ($this->isProducts) { ?>
                        <a class="nav-link active" href="?name=admin-area&product">Product<span
                                    class="sr-only">(current)</span></a>
                        <ul class="admin-sub-menu">
                            <li class="">
                                <a href="?name=admin-area&product">
                                    <?php echo !$this->isAddNew ?
                                        "<b>All Products</b>" :
                                        "All Products";
                                    ?>
                                </a>
                            </li>
                            <li>
                                <a href="?name=admin-area&product&add-new">
                                    <?php echo $this->isAddNew ?
                                        "<b>Add New</b>" :
                                        "Add New";
                                    ?>
                                </a>
                            </li>
                        </ul>
                    <?php } else { ?>
                        <a class="nav-link" href="?name=admin-area&product">Product</a>
                    <?php } ?>
                </li>
            </ul>
        </nav>
        <?php
    }
}