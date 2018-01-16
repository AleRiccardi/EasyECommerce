<?php
/**
 * Single page.
 */

require_once(dirname(__FILE__) . "/engine.php");

$currentPage = null;

if (isset($_GET['name'])) {
    $currentPage = $_GET['name'];
}

$listTemplate = array(
    "template/home.php",
    "template/user.php",
    "template/login.php",
    "template/registration.php",
    "template/edit-login.php",
    "template/cart.php",
    "template/order.php",
    "template/edit-address.php",
    "template/admin-area.php",
    "template/shop/shop.php",
    "template/shop/category.php",

);

$temp404 = "template/404.php";

$found = false;

if (!empty($currentPage)) {

    foreach ($listTemplate as $template) {
        $urlSplit = explode('/', $template);
        // take the name of the page (template/shop/category.php) -> category.php
        $page = $urlSplit[count($urlSplit)-1];
        // take out the extension category.php -> category
        $page = substr($page, 0, strpos($page, "."));
        // confront if the page is equal to the current page ($_GET['name'] == category)
        if($page == $currentPage){
            $found = true;
            require_once(dirname(__FILE__) . "/$template");
        }
    }

    if(!$found) require_once(dirname(__FILE__) . "/$temp404");
} else {
    echo "<i>nothing to load ...</i>";
}
