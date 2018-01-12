<?php
/**
 * Single page.
 */

require_once(dirname(__FILE__) . "/engine.php");

$currentPage = null;

if (isset($_GET['name'])) $currentPage = $_GET['name'];

$listTemplate = array(
    "template/home.php",
    "template/user.php",
    "template/login.php",
    "template/registration.php",
    "template/shop.php",
    "template/edit-login.php",
    "template/cart.php",
    "template/order.php",
    "template/edit-address.php",
);

$temp404 = "template/404.php";

$found = false;

if (!empty($currentPage)) {

    foreach ($listTemplate as $template) {
        $urlSplit = explode('/', $template);
        $page = $urlSplit[1];
        $page = substr($page, 0, strpos($page, "."));
        if($page == $currentPage){
            $found = true;
            require_once(dirname(__FILE__) . "/$template");
        }
    }

    if(!$found) require_once(dirname(__FILE__) . "/$temp404");
} else {
    echo "<i>nothing to load ...</i>";
}
