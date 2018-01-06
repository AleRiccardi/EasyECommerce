<?php
require_once(dirname(__FILE__) . "/template/header.php");

$login = new \Inc\Classes\Login();
if ($login->isUserLoggedIn() == true) {
    include("template/logged_in.php");

} else {
    include("template/not_logged_in.php");
}
