<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 12/01/2018
 * Time: 18:34
 */

namespace Inc\Admin;


use Inc\Utils\User;

class AdminEngine {
    const SLUG_OVERVIEW = "overview";
    const SLUG_ORDER = "order";
    const SLUG_CATEGORY = "category";
    const SLUG_PRODUCT = "product";
    const SLUG_USER = "user";

    // page overview
    private $isOverview = false;
    private $nameOverview = false;
    // page orders
    private $isOrders = false;
    private $nameOrder = null;
    // page categories
    private $isCategories = false;
    private $nameCategory = null;
    // page products
    private $isProducts = false;
    private $nameProduct = null;
    // page products
    private $isUsers = false;
    private $nameUser = null;

    private $isAddNew = false;

    private $overviewTemp = null;
    private $categoryTemp = null;
    private $productTemp = null;
    private $userTemp = null;


    public function __construct() {
        if (!User::isAdmin()) {
            $this->notAllowed();
            return false;
        } else {

            $this->overviewTemp = new Overview();
            $this->categoryTemp = new Category();
            $this->productTemp = new Product();
            $this->userTemp = new \Inc\Admin\User();

            $this->register();
        }
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

        } else if (isset($_GET[self::SLUG_ORDER])) {
            // ORDER
            $this->isOrders = true;
            $this->nameOrder = !empty($_GET[self::SLUG_ORDER]) ?
                $_GET[self::SLUG_ORDER] : null;
            $this->getSidebar();

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

        } else if (isset($_GET[self::SLUG_USER])) {
            // USER
            $this->isUsers = true;
            $this->nameUser = !empty($_GET[self::SLUG_USER]) ?
                $_GET[self::SLUG_USER] : null;
            $this->getSidebar();
            $this->userTemp->register();
        }


    }


    private function notAllowed() { ?>
        <section class="flex-container-center fit-height-section">
            <div class="flex-item-center">
                <div>
                    <h1 class="">You're not allowed to access to this page.</h1>
                </div>
            </div>
        </section>
        <?php
    }


    private function getSidebar() { ?>
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <!-- OVERVIEW -->
                    <li class="nav-item">
                        <a class="nav-link <?php if ($this->isOverview) echo "active"; ?>"
                           href="?name=admin-area&overview">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-home">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            Overview
                            <?php if ($this->isOverview) echo "<span class='sr-only'>(current)</span>"; ?>
                        </a>
                    </li>
                    <!-- ORDERS -->
                    <li class="nav-item">
                        <a class="nav-link <?php if ($this->isOrders) echo "active"; ?>"
                           href="?name=admin-area&order">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-file">
                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                <polyline points="13 2 13 9 20 9"></polyline>
                            </svg>
                            Orders
                            <?php if ($this->isOrders) echo "<span class='sr-only'>(current)</span>"; ?>
                        </a>
                    </li>
                    <!-- CATEGORY -->
                    <li class="nav-item">
                        <a class="nav-link <?php if ($this->isCategories) echo "active"; ?>"
                           href="?name=admin-area&category">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-layers">
                                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                <polyline points="2 17 12 22 22 17"></polyline>
                                <polyline points="2 12 12 17 22 12"></polyline>
                            </svg>
                            Category
                            <?php if ($this->isCategories) echo " <span class='sr-only'>(current)</span>" ?>
                        </a>
                        <?php if ($this->isCategories) { ?>
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
                        <?php } ?>
                    </li>
                    <!-- PRODUCTS -->
                    <li class="nav-item">

                        <a class="nav-link <?php if ($this->isProducts) echo "active"; ?>"
                           href="?name=admin-area&product">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-shopping-cart">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>
                            Product
                            <?php if ($this->isProducts) echo " <span class='sr-only'>(current)</span>" ?>

                        </a>
                        <?php if ($this->isProducts) { ?>
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
                        <?php } ?>
                    </li>
                    <!-- USERS -->
                    <li class="nav-item">
                        <a class="nav-link <?php if ($this->isUsers) echo "active"; ?>"
                           href="?name=admin-area&user">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            User
                            <?php if ($this->isUsers) echo "<span class='sr-only'>(current)</span>"; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <?php
    }
}