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
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="cont-logo">
            <a href="<?php echo $baseController->website_url ?>">
                <img class="logo" src="<?php echo $baseController->website_url ?>/assets/img/logo.png" alt="logo">
            </a>
        </div>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="wrap-menus collapse navbar-collapse" id="navbarsExampleDefault">
            <div class="cont-menu">
                <ul class="nav-menu">
                    <li class="nav-item"><a class="nav-link"
                                            href="<?php echo $baseController->website_url ?>/page.php?name=shop">Shop</a>
                    </li>
                    <?php if (!$login->isUserLoggedIn()) { ?>
                        <li class="nav-item"><a class="nav-link"
                                                href="<?php echo $baseController->website_url ?>/page.php?name=login">Login</a>
                        </li>
                        <li class="nav-item"><a class="nav-link"
                                                href="<?php echo $baseController->website_url ?>/page.php?name=registration">Registration</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <?php if ($login->isUserLoggedIn()) { ?>
                <div class="cont-menu-user">
                    <div class="nav-item dropdown">
                        <div class="mu-info" id="dropdown01" data-toggle="dropdown"
                             aria-haspopup="true" aria-expanded="true">
                            <div class="mu-img">
                                <div class="profile-image"
                                     style="background-image: url('<?php echo $baseController->website_url ?>/assets/img/icon/user-image-small.png');"></div>
                            </div>
                            <span class="mu-dd-button"><?php echo $_SESSION['user_name']; ?></span>
                        </div>
                        <div class="dropdown-menu mu-dd-content " aria-labelledby="dropdown01">
                            <a class="dropdown-item"
                               href="<?php echo $baseController->website_url ?>/page.php?name=user">User</a>
                            <a class="dropdown-item" href="#">Cart</a>
                            <a class="dropdown-item"
                               href="<?php echo $baseController->website_url ?>/page.php?name=login&logout">Logout</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </nav>
</header>

<?php if(0) { ?>
<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Help</a>
                </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
</header>

<?php }