<?php

namespace Inc\Utils;

use Inc\Database\Db;

/**
 * Class login
 * handles the user's login and logout process
 *
 * @package Inc\Classes
 */
class Login {

    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct() {

    }

    /**
     * Init function run form the Init class every
     * time that we load a page.
     */
    public function register() {
        // create/read session, absolutely necessary

        if (session_status() == PHP_SESSION_NONE && !headers_sent()) {
            session_start();
        }

        // check the possible login actions:
        // if user tried to log out (happen when user clicks logout button)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        } // login via post data (if user just submitted a login form)
        else if (isset($_POST["login"])) {
            $username = isset($_POST['userName']) ? $_POST['userName'] : "";
            $password = isset($_POST['userPassword']) ? $_POST['userPassword'] : "";
            $this->doLogin($username, $password);
        }
        $this->showError();
    }

    /**
     * Permit to login a user that exist in the db.
     *
     * @param $userName
     * @param $userPassword
     *
     * @return bool true if success, false otherwise
     */
    public function doLogin($userName, $userPassword) {

        if (empty($userName)) {
            $errors[] = "Username field was empty.";
        } elseif (empty($userPassword)) {
            $errors[] = "Password field was empty.";
        } elseif (!empty($userName) && !empty($userPassword)) {

            $userByName = User::getBy($userName, "username");
            $userByEmail = User::getBy($userName, "email");

            // if this user exists
            if ($userByName || $userByEmail) {

                $user = $userByName ? $userByName : $userByEmail;

                // using PHP 5.5's password_verify() function to check if the provided password fits
                // the hash of that user's password
                if (password_verify($userPassword, $user->passwordHash)) {

                    // write user data into PHP SESSION (a file on your server)
                    $_SESSION['userName'] = $user->userName;
                    $_SESSION['userEmail'] = $user->userEmail;
                    $_SESSION['userLoginStatus'] = 1;

                    return true;
                } else {
                    $this->errors[] = "Wrong username or password. Try again.";
                }
            } else {
                $this->errors[] = "Wrong username or password. Try again.";
            }
        }
        // default
        return false;
    }

    /**
     * perform the logout.
     */
    public function doLogout() {
        if ($this->isUserLoggedIn()) {
            // delete the session of the user
            $_SESSION = array();
            session_destroy();
            // return a little feeedback message
            $this->messages[] = "You have been logged out.";
        }
    }

    /**
     * simply return the current state of the user's login
     *
     * @return boolean user's login status
     */
    public function isUserLoggedIn() {
        if (isset($_SESSION['userLoginStatus']) AND $_SESSION['userLoginStatus'] == 1) {
            return true;
        }
        // default return
        return false;
    }

    /**
     * simply return the current state of the user's login
     *
     * @return boolean user's login status
     */
    public function showError() {
        if ($this->errors) { ?>
            <div class="message alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php
                foreach ($this->errors as $error) {
                    echo $error;
                }
                ?>
            </div>
            <?php
        }
        if ($this->messages) { ?>
            <div class="message alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php
                foreach ($this->messages as $message) {
                    echo $message;
                }
                ?>
            </div>
            <?php
        }

    }


}
