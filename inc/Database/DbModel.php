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
    protected static function getTableName() {
        $db = new Db();
        $tableName = static::$tableName;
        return $db->prefix . $tableName;
    }

    /**
     * Creation of the query and injection.
     *
     * @param string $type of query that we want to inject
     *
     * @param array  $data list of information that will be
     *                     placed after the expression WHERE
     *
     * @return string the name.
     */
    public static function fetchSql($type, $data) {

        if ($type == "SELECT") {
            $sql = "SELECT * FROM " . self::getTableName();
        } else if ($type == "UPDATE") {
            $sql = "UPDATE * FROM " . self::getTableName();
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
     * Get a somethings.
     *
     * @param array|null $data  list of information that will be
     *                          placed after the expression WHERE
     *
     * @return array|null
     */
    public static function get(array $data = null, $type = "OBJECT") {
        $db = new Db();
        $res = $db->getResults(self::fetchSql("SELECT", $data), $type);

        if (count($res) == 1) {
            $res = $res[0];
        }

        return $res;
    }

    /**
     * Insert
     *
     * @param $data
     *
     * @return array|bool|null|object|\stdClass
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
        return $db->query($sql);
    }

    /**
     * Update a row in the table
     *
     * @param array $data  Data to update (in column => value pairs).
     * @param array $where A named array of WHERE clauses (in column => value pairs).
     *
     * @return int|false The number of rows updated, or false on error.
     */
    public static function update(array $data, array $where) {
        // QUERY creation
        $sql = "UPDATE " . self::getTableName() . " SET ";

        $listKeys = array_keys($data);
        $lastKey = end($listKeys);
        foreach ($data as $key => $value) {
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
                $sql .= ", ";
            }
        }

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
                $sql .= ", ";
            }
        }

        $db = new Db();
        return $db->query($sql);
    }

    /**
     * Delete the rows that match with the information tha we
     * passed throw param.
     *
     * @param array $data
     *
     * @return mixed
     */
    public static function delete(array $data) {
        $db = new Db();
        $sql = self::fetchSql('DELETE', $data);
        return $db->query($sql);
    }

    /**
     * Get the time now.
     *
     * @return false|string
     */
    public static function now() {
        return date('Y-m-d H:i:s');
    }

}