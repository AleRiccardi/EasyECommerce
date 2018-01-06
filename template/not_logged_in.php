<?php
// show potential errors / feedback (from login object)

if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo $error;
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo $message;
        }
    }
}
?>

<!-- login form box
<form method="post" action="index.php" name="loginform">

    <label for="login_input_username">Username</label>
    <input id="login_input_username" class="login_input" type="text" name="user_name" required/>

    <label for="login_input_password">Password</label>
    <input id="login_input_password" class="login_input" type="password" name="user_password" autocomplete="off"
           required/>

    <input type="submit" name="login" value="Log in"/>

</form>
-->


<section class="flex-container-center home-section">
    <div class="container flex-item-center">
        <form class="form-signin" method="post" action="login.php" name="loginform">
            <h2 class="form-signin-heading">Please sign in</h2>
            <label for="login_input_username" class="sr-only">Username</label>
            <input name="user_name" id="login_input_username" class="form-control" placeholder="Username" required=""
                   autofocus="">
            <label for="login_input_password" class="sr-only">Password</label>
            <input type="password" id="login_input_password" class="form-control" placeholder="Password" name="user_password"
                   autocomplete="off" required="">
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Sign in</button>
        </form>
        <a href="register.php">Register new account</a>

    </div>
</section>