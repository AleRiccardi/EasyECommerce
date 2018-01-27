<?php

use Inc\Utils\User;
use Inc\Base\Redirect;

$redirect = new Redirect();

if ($user = User::getCurrentUser()) {
    if (isset($_POST["login"])) {
        $redirect->redirectToRestrict();
    }
}

$nextPage = null;
if (isset($_GET['next'])) {
    $nextPage = $_GET['next'];
}

require_once($baseController->website_path . "/template/_header.php");
$userName = isset($_POST['userName']) ? $_POST['userName'] : "";

?>
    <main>
        <section class="flex-container-center fit-height-section">
            <div class="container flex-item-center">
                <form class="form-signin" method="post" action="page.php?name=login<?php if($nextPage) echo "&next=$nextPage"; ?>" name="loginform">
                    <h2 class="form-signin-heading">Please sign in</h2>
                    <label for="login_input_username" class="sr-only">Username</label>
                    <input name="userName" id="login_input_username" class="form-control" placeholder="Username"
                           required="" autofocus="" value="<?php
                    if($user) echo $user->userEmail;
                    else echo $userName;
                    ?>">
                    <label for="login_input_password" class="sr-only">Password</label>
                    <input type="password" id="login_input_password" class="form-control" placeholder="Password"
                           name="userPassword"
                           autocomplete="off" required="">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value="remember-me"> Remember me
                        </label>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Sign in</button>
                </form>
                <a href="page.php?name=registration">Register new account</a>

            </div>
        </section>
    </main>

<?php

require_once($baseController->website_path . "/template/_footer.php");

