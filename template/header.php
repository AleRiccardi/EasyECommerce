<?php

$baseController = new \Inc\Base\BaseController();
$login = new \Inc\Classes\Login();

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
        <div class="container">
            <div class="cont-logo">
                <img id="logo" src="<?php echo $baseController->website_url ?>/assets/img/logo.png" alt="logo"
                     width="70px"
                     height="70px">
            </div>

            <div class="wrap-menus">
                <div class="cont-menu">
                    <ul class="nav-menu">
                        <li class="nav-item active"><a class="nav-link" href="./"> Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="./curiosity.php">Curiosity</a></li>
                        <?php if (!$login->isUserLoggedIn()) { ?>
                            <li class="nav-item"><a class="nav-link" href="./login.php">Login</a></li>
                            <li class="nav-item"><a class="nav-link"href="./registration.php">Registration</a></li>
                        <?php } ?>
                    </ul>
                </div>

                <?php if ($login->isUserLoggedIn()) { ?>
                    <div class="cont-menu-user">
                        <div class="nav-item dropdown">
                            <!--<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Dropdown</a>-->
                            <div class="mu-info " href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <div class="mu-img">
                                    <div class="profile-image"></div>
                                </div>
                                <span class="mu-dd-button"><?php echo $_SESSION['user_name']; ?></span>
                            </div>
                            <div class="dropdown-menu mu-dd-content " aria-labelledby="dropdown01">
                                <a class="dropdown-item" href="#">User</a>
                                <a class="dropdown-item" href="#">Cart</a>
                                <a class="dropdown-item" href="<?php echo $baseController->website_url ?>/login.php?logout">Logout</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        </div>
    </nav>
</header>

