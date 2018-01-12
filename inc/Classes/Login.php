<?php

namespace Inc\Classes;

use Inc\Database\Db;

/**
 * Class login
 * handles the user's login and logout process
 *
 * @package Inc\Classes
 */
class Login {

    /**
     * @var object The database connection
     */
    private $db_connection = null;
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
            //$this->doStaticLogin($username, $password);
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

            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new \mysqli(Db::HOST, Db::USER, Db::PASS, Db::NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escape the POST stuff
                $userName = $this->db_connection->real_escape_string($_POST['userName']);

                $userByName = User::getByNameOrEmail($userName, "USERNAME");
                $userByEmail = User::getByNameOrEmail($userName, "USEREMAIL");

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
                        $this->errors[] = "Wrong password. Try again.";
                    }
                } else {
                    $this->errors[] = "This user does not exist.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
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
