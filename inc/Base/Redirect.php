<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 26/01/2018
 * Time: 15:04
 */

namespace Inc\Base;


use Inc\Utils\User;

class Redirect extends BaseController {
    private $resctrictPages = [
        "template/user.php",
        "template/edit-login.php",
        "template/edit-address.php",
        "template/order.php",
        "template/cart.php",
        "template/checkout.php",
        "template/checkout-success.php",
    ];


    public function register() {
        $this->restrictAccess();
    }

    public function restrictAccess() {
        if (!$user = User::getCurrentUser()) {
            if (isset($_GET['name'])) {
                $currentPage = $_GET['name'];

                if (!User::getCurrentUser()) {
                    foreach ($this->resctrictPages as $template) {
                        $urlSplit = explode('/', $template);
                        // take the name of the page (template/shop/category.php) -> category.php
                        $page = $urlSplit[count($urlSplit) - 1];
                        // take out the extension category.php -> category
                        $page = substr($page, 0, strpos($page, "."));
                        // confront if the page is equal to the current page ($_GET['name'] == category)
                        if ($page == $currentPage) {
                            header("Location: $this->website_url/page.php?name=login&next=$page");
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    public function redirectToRestrict() {
        if (isset($_GET['next'])) {
            $nextPage = $_GET['next'];
            $found = false;

            foreach ($this->resctrictPages as $template) {
                $urlSplit = explode('/', $template);
                // take the name of the page (template/shop/category.php) -> category.php
                $page = $urlSplit[count($urlSplit) - 1];
                // take out the extension category.php -> category
                $page = substr($page, 0, strpos($page, "."));
                // confront if the page is equal to the current page ($_GET['name'] == category)
                if ($page == $nextPage) {
                    $found = true;
                    header("Location: $this->website_url/page.php?name=$nextPage");
                }
            }

            if (!$found) header("Location: $this->website_url/page.php?name=login");

        } else {
            header("Location: $this->website_url/page.php?name=user");
        }
    }
}