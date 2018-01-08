<?php

$login = new \Inc\Classes\Login();

if ($login->isUserLoggedIn() == true) {
    header("Location: $baseController->website_url/page.php?name=user");
    die();

} else {
    require_once($baseController->website_path . "/template/_header.php");

    ?>
    <section class="flex-container-center fit-height-section">
        <div class="container flex-item-center">
            <form class="form-signin" method="post" action="page.php?name=registration" name="registerform">
                <h2 class="form-signin-heading">Registration</h2>

                <!-- fake fields are a workaround for chrome autofill getting the wrong fields -->

                <label for="register_input_username" class="sr-only">Username</label>
                <input name="user_name" id="register_input_username" class="form-control" placeholder="Username"
                       required=""
                       type="text" pattern="[a-zA-Z0-9]{2,64}" autofocus="" autocomplete="off">

                <label for="register_input_email" class="sr-only">Email</label>
                <input name="user_email" id="register_input_email" class="form-control" placeholder="Email" required=""
                       type="email" autocomplete="off">

                <label for="register_input_password" class="sr-only">Password</label>
                <input name="user_password_new" id="register_input_password" class="form-control" placeholder="Password"
                       type="password" autocomplete="off" required="" autocomplete="nope">

                <label for="login_input_password_repeat" class="sr-only">Password</label>
                <input name="user_password_repeat" id="login_input_password_repeat" class="form-control"
                       placeholder="Repeat password"
                       type="password" autocomplete="off" required="" autocomplete="nope">

                <br>
                <button class="btn btn-lg btn-primary btn-block" name="register" type="submit">Register</button>
            </form>
            <a href="login.php">Back to Login Page</a>

        </div>
    </section>

    <?php
    require_once($baseController->website_path . "/template/_footer.php");

}