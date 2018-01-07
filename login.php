<?php

require_once(dirname(__FILE__) . "/engine.php");

$login = new \Inc\Classes\Login();

if ($login->isUserLoggedIn() == true) {
    header("Location: page.php?name=user");
    die();

} else {
    require_once(dirname(__FILE__) . "/template/_header.php");
    include("template/login.php");
    require_once(dirname(__FILE__) . "/template/_footer.php");
}

