<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 15/01/2018
 * Time: 11:05
 */

namespace Inc\Database;


class DbProduct extends DbModel {
    // database name
    static $tableName = "item";

    /**
     * @param $data
     *
     * @return int id of row
     */
    public static function insert($data) {
        $product = null;

        // If doesn't exist
        if(!($product = self::get($data, "OBJECT"))) {
            $idRow = parent::insert($data);
            return $idRow;
        } else {
            return $product->id;
        }
    }

}