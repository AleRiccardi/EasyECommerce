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
    public $lastResult = null;

    public $errors = array();
    public $log = array();

    public function __construct() {
        $this->dbConn = new \mysqli(Db::HOST, Db::USER, Db::PASS, Db::NAME);

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
     * @return bool|\mysqli_result|null
     */
    /**
     * @param $sql
     *
     * @return array|null|object|\stdClass
     */
    /**
     * @param $sql
     *
     * @return array|bool|null|object|\stdClass
     */
    public function query($sql) {
        //if error
        if(!$ret = $this->dbConn->query($sql)) return null;
        //if is just a normal query without nothing to return
        if($ret === true) return true;

        //if have information
        if($ret->num_rows == 1) {
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
     * @param $table
     * @param $data
     *
     * @return bool|\mysqli_result
     */
    public function insert($table, $data) {

        // QUERY creation
        $sql = "INSERT INTO $table (";

        $listKeys = array_keys($data);
        $lastKey = end($listKeys);
        foreach($data as $key => $value){
            $sql .= "$key";
            if(!($key == $lastKey)){
                $sql .= ", ";
            }
        }
        $sql .= ") VALUES (";
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $sql .= "'$value'";
            } else {
                $sql .=  $value;
            }

            if (!($key == $lastKey)) {
                $sql .= ", ";
            }
        }
        $sql .= ")";

        return $this->query($sql);
    }

    /**
     * Update a row in the table
     *
     *     wpdb::update( 'table', array( 'column' => 'foo', 'field' => 'bar' ), array( 'ID' => 1 ) )
     *     wpdb::update( 'table', array( 'column' => 'foo', 'field' => 1337 ), array( 'ID' => 1 ), array( '%s', '%d' ), array( '%d' ) )
     *
     * @since 2.5.0
     * @see wpdb::prepare()
     * @see wpdb::$field_types
     * @see wp_set_wpdb_vars()
     *
     * @param string       $table        Table name
     * @param array        $data         Data to update (in column => value pairs).
     *                                   Both $data columns and $data values should be "raw" (neither should be SQL escaped).
     *                                   Sending a null value will cause the column to be set to NULL - the corresponding
     *                                   format is ignored in this case.
     * @param array        $where        A named array of WHERE clauses (in column => value pairs).
     *                                   Multiple clauses will be joined with ANDs.
     *                                   Both $where columns and $where values should be "raw".
     *                                   Sending a null value will create an IS NULL comparison - the corresponding format will be ignored in this case.
     * @param array|string $format       Optional. An array of formats to be mapped to each of the values in $data.
     *                                   If string, that format will be used for all of the values in $data.
     *                                   A format is one of '%d', '%f', '%s' (integer, float, string).
     *                                   If omitted, all values in $data will be treated as strings unless otherwise specified in wpdb::$field_types.
     * @param array|string $where_format Optional. An array of formats to be mapped to each of the values in $where.
     *                                   If string, that format will be used for all of the items in $where.
     *                                   A format is one of '%d', '%f', '%s' (integer, float, string).
     *                                   If omitted, all values in $where will be treated as strings.
     * @return int|false The number of rows updated, or false on error.
     */
    public function update( $table, $data, $where ) {

        // QUERY creation
        $sql = "UPDATE $table SET ";

        $listKeys = array_keys($data);
        $lastKey = end($listKeys);
        foreach($data as $key => $value){
            $sql .= "$key = ";

            if (is_string($value)) {
                $sql .= "'$value'";
            } else if(is_numeric($value)){
                $sql .=  $value;
            } else if(is_null($value)){
                $sql .=  "NULL";
            } else {
                return null;
            }

            if(!($key == $lastKey)){
                $sql .= ", ";
            }
        }

        $sql .= " WHERE ";

        $listKeys = array_keys($where);
        $lastKey = end($listKeys);
        foreach($where as $key => $value){
            $sql .= "$key = ";

            if (is_string($value)) {
                $sql .= "'$value'";
            } else {
                $sql .=  $value;
            }

            if(!($key == $lastKey)){
                $sql .= ", ";
            }
        }
        return $this->query($sql);
    }

    /**
     * Get results.
     *
     * @param null   $query
     * @param string $output
     *
     * @return array|null
     */
    public function getResults($query = null, $output = OBJECT) {
        $this->log = "\$db->get_results(\"$query\", $output)";
        if ($this->checkCurrentQuery() && $this->checkSafeCollation($query)) {
            $this->query($query);

        } else {
            return null;
        }

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

    /**
     * @return int
     */
    private function checkCurrentQuery() {
        if ($this->log) return 1;
    }

    /**
     * @param $query
     *
     * @return int
     */
    private function checkSafeCollation($query) {
        if ($query) return 1;
    }
}