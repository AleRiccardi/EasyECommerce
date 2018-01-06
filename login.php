<?php

require_once(dirname(__FILE__) . "/engine.php");

$login = new \Inc\Classes\Login();

if ($login->isUserLoggedIn() == true) {
    header("Location: index.php");
    die();

} else {
    require_once(dirname(__FILE__) . "/template/header.php");
    include("template/not_logged_in.php");
    require_once(dirname(__FILE__) . "/template/footer.php");
}

