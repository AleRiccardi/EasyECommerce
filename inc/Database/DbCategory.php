<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 15/01/2018
 * Time: 11:05
 */

namespace Inc\Database;


class DbCategory extends DbModel {
    // database name
    static $tableName = "category";

    /**
     * @param $data
     *
     * @return int id of row
     */
    public static function insert($data) {
        $category = null;

        // If doesn't exist
        if(!($category = self::get($data, "OBJECT"))) {
            $idRow = parent::insert($data);
            return $idRow;
        } else {
            return $category->id;
        }
    }

}