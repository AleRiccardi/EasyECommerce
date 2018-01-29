<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 15/01/2018
 * Time: 11:05
 */

namespace Inc\Database;


class DbItem extends DbModel {
    // database name
    static $tableName = "item";

    public static function get(array $where, $output) {
        if (!isset($where["available"])) $where["available"] = 1;
        return parent::get($where, $output);
    }

    public static function getSingle(array $where, $output) {
        if (!isset($where["available"])) $where["available"] = 1;
        return parent::getSingle($where, $output);
    }

    public static function getAll($type, array $where = null) {
        $where = ["available" => 1];
        return parent::getAll($type, $where);
    }

    public static function getFiltered(array $filter, array $where, $output) {
        if (!isset($where["available"])) $where["available"] = 1;
        $sql = self::fetchSql($where, "SELECT");

        if (!empty($filter)) {
            $length = count($filter) - 1;
            $sql .= " ORDER BY ";

            foreach ($filter as $key => $value) {
                $sql .= "$key $value";

                //Add 'AND' only if is not the last field
                if (array_search($key, array_keys($filter)) !== $length) {
                    $sql .= ", ";
                }
            }
        }
        $res = self::getResult($sql, $output);
        return $res;
    }

}