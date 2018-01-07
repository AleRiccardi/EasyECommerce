<?php
/**
 * Single page.
 */

require_once(dirname(__FILE__) . "/engine.php");
require_once(dirname(__FILE__) . "/template/_header.php");

$pageName = null;

if (isset($_GET['name'])) $pageName = $_GET['name'];

$listTemplate = array(
    "name" => array("/template/user.php", "/template/login.php")
);

if (!empty($pageName)) {
    switch ($pageName) {
        case "user":
            $name = $listTemplate['name'][0];
            require_once(dirname(__FILE__) . "$name");
            break;
        default:
            $name = $listTemplate['name'][1];
            require_once(dirname(__FILE__) . "$name");
            break;
    }
} else {
    echo "<i>nothing to load ...";
}

require_once(dirname(__FILE__) . "/template/_footer.php");
