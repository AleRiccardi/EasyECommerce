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
        if(!isset($where["available"])) $where["available"] = 1;
        return parent::get($where, $output);
    }

    public static function getSingle(array $where, $output) {
        if(!isset($where["available"])) $where["available"] = 1;
        return parent::getSingle($where, $output);
    }

    public static function getAll($type, array $where = null) {
        $where = ["available" => 1];
        return parent::getAll($type, $where);
    }

}