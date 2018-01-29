<?php
/**
 * Configuration for: Database Connection
 *
 * For more information about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 *
 * DB_HOST: database host, usually it's "127.0.0.1" or "localhost", some servers also need port info
 * DB_NAME: name of the database. please note: database and database table are not the same thing
 * DB_USER: user for your database. the user needs to have rights for SELECT, UPDATE, DELETE and INSERT.
 * DB_PASS: the password of the above user
 */

namespace Inc\Database;

define('OBJECT', 'OBJECT');
define('object', 'OBJECT'); // Back compat.22
define('OBJECT_K', 'OBJECT_K');
define('ARRAY_A', 'ARRAY_A');
define('ARRAY_N', 'ARRAY_N');


/**
 * Class Db
 *
 * @package Inc\Database
 */
class Db {
    const HOST = "localhost";
    const NAME = "restaurant";
    const USER = "root";
    const PASS = "root";

    public $prefix = "";

    public $dbConn = null;
    public $insertId;
    public $lastResult = null;

    public $errors = array();
    public $log = array();

    /**
     * Initializing of the database.
     */
    public function __construct() {
        $this->dbConn = new \mysqli(Db::HOST, Db::USER, Db::PASS, Db::NAME);
        //var_dump($z);
        // change character set to utf8 and check it
        if (!$this->dbConn->set_charset("utf8")) $this->errors[] = $this->dbConn->error;
        // database error
        if (!$this->dbConn->connect_errno) $this->errors[] = $this->dbConn->connect_errno;
    }

    /**
     * Execute a query.
     *
     * @param $sql
     *
     * @return bool|array of object if the query return something, true if doesn't
     *                    return nothing but with success and false otherwise
     */
    public function query($sql) {
        $ret = $this->dbConn->query($sql);

        //if is just a normal query without nothing to return
        if ($ret === true) {
            //If is like an insert permit to retrieve information about the last id
            $this->insertId = $this->dbConn->insert_id ? $this->dbConn->insert_id : null;
            return true;
        } else if ($ret === false) {
            return false;
        }

        /* check connection */
        if ($this->dbConn->connect_errno) {
            printf("Connect failed: %s\n", $this->dbConn->connect_error);
            return false;
        }

        //if have information
        if ($ret->num_rows == 1) {
            $this->lastResult = $ret->fetch_object();
            $this->lastResult = array($this->lastResult);
        } else {
            while ($obj = $ret->fetch_object()) {
                $this->lastResult[] = $obj;
            }
        }

        return $this->lastResult;
    }


    /**
     * Get results in base of the kind of result that we want.
     *
     * @param null   $query  the query to inject
     * @param string $output OBJECT / OBJECT_K / ARRAY_A / ARRAY_N
     *
     * @return array|null
     */
    public function getResults($query, $output = OBJECT) {
        $this->query($query);

        $new_array = array();
        if ($output == OBJECT) {
            // Return an integer-keyed array of row objects
            return $this->lastResult;
        } elseif ($output == OBJECT_K) {
            // Return an array of row objects with keys from column 1
            // (Duplicates are discarded)
            foreach ($this->lastResult as $row) {
                $var_by_ref = get_object_vars($row);
                $key = array_shift($var_by_ref);
                if (!isset($new_array[$key]))
                    $new_array[$key] = $row;
            }
            return $new_array;
        } elseif ($output == ARRAY_A || $output == ARRAY_N) {
            // Return an integer-keyed array of...
            if ($this->lastResult) {
                foreach ((array)$this->lastResult as $row) {
                    if ($output == ARRAY_N) {
                        // ...integer-keyed row arrays
                        $new_array[] = array_values(get_object_vars($row));
                    } else {
                        // ...column name-keyed row arrays
                        $new_array[] = get_object_vars($row);
                    }
                }
            }
            return $new_array;
        } elseif (strtoupper($output) === OBJECT) {
            // Back compat for OBJECT being previously case insensitive.
            return $this->lastResult;
        }
        return null;
    }
}