<?php
/**
 * Created by PhpStorm.
 * User: aleric
 * Date: 12/01/2018
 * Time: 12:31
 */

namespace Inc\Database;


class DbAddress extends DbModel {
    // database name
    static $tableName = "address";

    /**
     * @param $data
     *
     * @return int id of row
     */
    public static function insert($data) {
        $address = null;

        // If doesn't exist
        if(!($address = self::get($data, "OBJECT"))) {
            $idRow = parent::insert($data);
            return $idRow;
        } else {
            return $address->id;
        }
    }

}