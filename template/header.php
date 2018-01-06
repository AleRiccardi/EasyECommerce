<?php

// Define CONSTANTS
define('PLUGIN_PATH', dirname(__FILE__, 2));

// Require once the Composer Autoload
if (file_exists(PLUGIN_PATH . '/vendor/autoload.php')) {
    require_once PLUGIN_PATH . '/vendor/autoload.php';
}

/**
 * Initialize all the core classes of the plugin
 *
 * @since 1.0.0
 */
if (class_exists(Inc\Init::class)) {
    Inc\Init::registerServices();
}

$baseController = new \Inc\Base\BaseController();

?>

<html lang="it">
<head>
    <meta charset="utf-8" content="text/html" ;>
    </meta>
    <title>ZB Sushi</title>
    <?php require_once("head.php"); ?>
</head>
<body>
<header>
    <nav class="navbar">
        <div class="container ">
            <img id="logo1" src="<?php echo $baseController->website_url ?>/assets/img/logo.png" alt="logo" width="70px"
                 height="70px">

            <div class="cont-menu">
                <ul class="menu">
                    <li><a href="./"> Home</a></li>
                    <li><a href="./curiosita.php">Curiosità</a></li>
                    <li><a href="./login.php">Login</a></li>
                    <li><a href="./registration.php">Registration</a></li>
                </ul>
            </div>
        </div>
        </div>
    </nav>
</header>

