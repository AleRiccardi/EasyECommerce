<?php

namespace Inc\Database;

use \Inc\Database\Db;

/**
 * The default class that manage the database in the
 * most basic way, without control and with the only
 * intention to inject the queries.
 *
 * @package Inc\Database
 */
class DbModel {
    const DB_VERSION = '1.0.0';
    const DB_NAME_VERSION = 'OBF_db_version';
    // default database name
    static $tableName = "model";

    /**
     * Retrieve the name of the database with included
     * also the prefix.
     *
     * @return string the name.
     */
    public static function getTableName() {
        $db = new Db();
        $tableName = static::$tableName;
        return $db->prefix . $tableName;
    }

    /**
     * Creation of the query for the Selection and deletion.
     *
     * @param string $type of query that we want to inject
     *
     * @param array  $data list of information that will be
     *                     placed after the expression WHERE
     *
     * @return string the sql query.
     */
    public static function fetchSql($data, $type) {

        if ($type == "SELECT") {
            $sql = "SELECT * FROM " . self::getTableName();
        } else if ($type == "DELETE") {
            $sql = "DELETE FROM " . self::getTableName();
        }

        if ($data == null) {
            return $sql;
        } else {

            $length = count($data) - 1;
            $sql .= " WHERE ";

            foreach ($data as $key => $value) {
                if (is_string($value)) {
                    $sql .= "$key = '$value'";
                } else {
                    $sql .= "$key = $value";
                }

                //Add 'AND' only if is not the last field
                if (array_search($key, array_keys($data)) !== $length) {
                    $sql .= " AND ";
                }
            }

            return $sql;
        }
    }

    /**
     * Get information from table.
     *
     * @param array|null $where list of information that will be
     *                          placed after the expression WHERE
     * @param string     $output  OBJECT / OBJECT_K / ARRAY_A / ARRAY_N
     *
     * @return array of information (the type of information depend
     *               to the kind of param that you specify –$type-)
     */
    public static function get(array $where, $output) {
        $db = new Db();
        $query = self::fetchSql($where, "SELECT");
        $res = $db->getResults($query, $output);

        if (empty($res)) $res = array();

        return $res;
    }

    /**
     * Get information from table.
     *
     * @param array|null $where list of information that will be
     *                          placed after the expression WHERE
     * @param string     $output  OBJECT / OBJECT_K / ARRAY_A / ARRAY_N
     *
     * @return array|object|null array of results, if single will be as an object,
     *                    null if error.
     */
    public static function getSingle(array $where, $output) {
        $db = new Db();
        $query = self::fetchSql($where, "SELECT");
        $res = $db->getResults($query, $output);

        // take out the first element of the array inside a
        // variable, like --> array(value) --> value
        $res = $res[0];

        return $res;
    }

    /**
     * Get all the information from table.
     *
     * @param array|null $where
     * @param string $type OBJECT / OBJECT_K / ARRAY_A / ARRAY_N
     *
     * @return array|object|null array of results, if single will be as an object,
     *                    null if error.
     */
    public static function getAll($type, array $where = null) {
        $db = new Db();
        $query = self::fetchSql($where, "SELECT");
        $res = $db->getResults($query, $type);

        return $res;
    }


    public static function getResult($query, $output = OBJECT){
        $db = new Db();
        $res = $db->getResults($query, $output);
        return $res;
    }

    /**
     * Insert in the table
     *
     * @param array $data information to be insert
     *
     * @return bool|int id of the row if everything right, false otherwise
     */
    public static function insert($data) {
        // QUERY creation
        $sql = "INSERT INTO " . self::getTableName() . " (";

        $listKeys = array_keys($data);
        $lastKey = end($listKeys);
        foreach ($data as $key => $value) {
            $sql .= "$key";
            if (!($key == $lastKey)) {
                $sql .= ", ";
            }
        }
        $sql .= ") VALUES (";
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $sql .= "'$value'";
            } else {
                $sql .= $value;
            }

            if (!($key == $lastKey)) {
                $sql .= ", ";
            }
        }
        $sql .= ")";
        $db = new Db();
        $resultQ = $db->query($sql);
        if ($db->insertId && $resultQ === true) {
            return $db->insertId != null ? $db->insertId : true;
        } else if ($db->query($sql) === true) {
            return true;
        }

        return false;
    }

    /**
     * Update a row in the table
     *
     * @param array $data  Data to update (in column => value pairs).
     * @param array $where A named array of WHERE clauses (in column => value pairs).
     *
     * @return int|false The number of rows updated, or false for errors.
     */
    public static function update(array $data, array $where) {
        // QUERY creation
        $sql = "UPDATE " . self::getTableName();
        $listKeys = array_keys($data);
        $lastKey = end($listKeys);
        // DATA
        $sql .= " SET ";
        foreach ($data as $key => $value) {
            $sql .= "$key = ";
            if (is_string($value)) {
                $sql .= "'$value'";
            } else if (is_numeric($value)) {
                $sql .= $value;
            } else if (is_null($value)) {
                $sql .= "NULL";
            } else {
                $sql .= $value;
            }

            if (!($key == $lastKey)) {
                $sql .= ", ";
            }
        }

        // WHERE
        $sql .= " WHERE ";
        $listKeys = array_keys($where);
        $lastKey = end($listKeys);
        foreach ($where as $key => $value) {
            $sql .= "$key = ";

            if (is_string($value)) {
                $sql .= "'$value'";
            } else if (is_numeric($value)) {
                $sql .= $value;
            } else if (is_null($value)) {
                $sql .= "NULL";
            } else {
                return null;
            }

            if (!($key == $lastKey)) {
                $sql .= " AND ";
            }
        }
        $db = new Db();
        return $db->query($sql);
    }

    /**
     * Delete the rows that match with the id tha it'is
     * passed throw param.
     *
     * @param int $id
     *
     * @return bool value (to be tested)
     */
    public static function delete($id) {
        $db = new Db();
        $sql = self::fetchSql(["id" => $id], 'DELETE');
        return $db->query($sql) ? true : false;
    }

    /**
     * Get the time now.
     *
     * @return false|string of the date, false if errors
     */
    public static function now() {
        return date('Y-m-d H:i:s');
    }

}