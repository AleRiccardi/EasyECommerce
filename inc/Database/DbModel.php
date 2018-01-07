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
    static $tableName = "obf_model";

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
    public static function get(array $data = null, $type = OBJECT) {
        $db = new Db();
        return $db->getResults(self::fetchSql("SELECT", $data), $type);
    }

    /**
     * NOT WORKING
     *
     * @param array $data
     *
     * @return mixed
     */
    public static function insert(array $data) {
        $db = new Db();
        $res = $db->insert(self::getTableName(), $data);
        return $res;
    }

    /**
     * NOT WORKING
     *
     * @param array $data
     * @param array $where
     */
    public static function update(array $data, array $where) {
        $db = new Db();
        $db->update(self::getTableName(), $data, $where);
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
        echo $sql = self::fetchSql('DELETE', $data);
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