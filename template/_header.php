<?php

$baseController = new \Inc\Base\BaseController();
$login = new \Inc\Classes\Login();

?>

<html lang="it">
<head>
    <meta charset="utf-8" content="text/html" ;>
    </meta>
    <title>ZB Sushi</title>
    <?php require_once("_head.php"); ?>
</head>
<body>
<header>
    <nav class="navbar">
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
                        <li class="nav-item"><a class="nav-link" href="./registration.php">Registration</a></li>
                    <?php } ?>
                </ul>
            </div>

            <?php if ($login->isUserLoggedIn()) { ?>
                <div class="cont-menu-user">
                    <div class="nav-item dropdown">
                        <div class="mu-info" id="dropdown01" data-toggle="dropdown"
                             aria-haspopup="true" aria-expanded="true">
                            <div class="mu-img">
                                <div class="profile-image" style="background-image: url('<?php echo $baseController->website_url ?>/assets/img/icon/user-image-small.png');"></div>
                            </div>
                            <span class="mu-dd-button"><?php echo $_SESSION['user_name']; ?></span>
                        </div>
                        <div class="dropdown-menu mu-dd-content " aria-labelledby="dropdown01">
                            <a class="dropdown-item"
                               href="<?php echo $baseController->website_url ?>/page.php?name=user">User</a>
                            <a class="dropdown-item" href="#">Cart</a>
                            <a class="dropdown-item" href="<?php echo $baseController->website_url ?>/login.php?logout">Logout</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </nav>
</header>

