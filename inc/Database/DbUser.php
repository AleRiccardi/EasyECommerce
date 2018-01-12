<?php

namespace Inc\Database;

/**
 * That class manage the database table for the badges
 * that are sent.
 *
 * @package Inc\Database
 */
class DbUser extends DbModel {
    const ER_DONT_EXIST = "The badge don't exist.\n";
    const ER_DUPLICATE = "The badge is duplicate.\n";
    const ER_WRONG_FIELDS = "Wrong fields passed in the array.\n";
    const ER_ERROR = "There's an error in the database.\n";
    // database name
    static $tableName = "users";

    /**
     * In that function, called from the Init class,
     * permit to create the database.
     */
    public function register() {

    }

}