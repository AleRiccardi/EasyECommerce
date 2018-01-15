<?php

namespace Inc\Classes;

use Inc\Database\Db;
use Inc\Database\DbUser;

/**
 * Handles the user registration
 *
 * @package Inc\Classes
 */
class Registration {
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * Init function run form the Init class every
     * time that we load a page.
     */
    public function register() {
        if (session_status() == PHP_SESSION_NONE && !headers_sent()) {
            session_start();
        }

        if (isset($_POST["register"])) {
            if ($this->registerNewUser()) {
                $login = new Login();
                $login->doLogin($_POST['userName'], $_POST['userPasswordNew']);
            } else {
                $this->showError();
            }
        }
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     *
     * @return bool true if success, false otherwise
     */
    private function registerNewUser() {
        if (empty($_POST['userName'])) {
            $this->errors[] = "Empty Username";
        } elseif (empty($_POST['userPasswordNew']) || empty($_POST['userPassword_repeat'])) {
            $this->errors[] = "Empty Password";
        } elseif ($_POST['userPasswordNew'] !== $_POST['userPassword_repeat']) {
            $this->errors[] = "The password doesn't match";
        } elseif (strlen($_POST['userPasswordNew']) < 6) {
            $this->errors[] = "Password has a minimum length of 6 characters";
        } elseif (strlen($_POST['userName']) > 64 || strlen($_POST['userName']) < 2) {
            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['userName'])) {
            $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        } elseif (empty($_POST['userEmail'])) {
            $this->errors[] = "Email cannot be empty";
        } elseif (strlen($_POST['userEmail']) > 64) {
            $this->errors[] = "Email cannot be longer than 64 characters";
        } elseif (!filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Your email address is not in a valid email format";
        } elseif (!empty($_POST['userName'])
            && strlen($_POST['userName']) <= 64
            && strlen($_POST['userName']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['userName'])
            && !empty($_POST['userEmail'])
            && strlen($_POST['userEmail']) <= 64
            && filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['userPasswordNew'])
            && !empty($_POST['userPassword_repeat'])
            && ($_POST['userPasswordNew'] === $_POST['userPassword_repeat'])
        ) {
            // create a database connection
            $this->db_connection = new \mysqli(Db::HOST, Db::USER, Db::PASS, Db::NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escaping, additionally removing everything that could be (html/javascript-) code
                $userName = $this->db_connection->real_escape_string(strip_tags($_POST['userName'], ENT_QUOTES));
                $userEmail = $this->db_connection->real_escape_string(strip_tags($_POST['userEmail'], ENT_QUOTES));

                $userPassword = $_POST['userPasswordNew'];

                // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
                $userPassword_hash = password_hash($userPassword, PASSWORD_DEFAULT);

                // check if user or email address already exists
                if (User::getBy($userName, "USERNAME") || User::getBy($userEmail, "USEREMAIL")) {
                    $this->errors[] = "Sorry, that username / email address is already taken.";
                } else {
                    // write new user's data into database
                    $insertResponse = User::registerNewUser($userName, $userEmail, $userPassword_hash);

                    // if user has been added successfully
                    if ($insertResponse) {
                        $this->messages[] = "Your account has been created successfully. You can now log in.";
                        return true;
                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                    }
                }
            } else {
                $this->errors[] = "Sorry, no database connection.";
            }
        } else {
            $this->errors[] = "An unknown error occurred.";
        }

        //default return;
        return false;
    }

    /**
     * Simply return the current state of the user's login
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
