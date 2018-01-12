<?php

namespace Inc\Database;

/**
 * That class manage the database table for the badges
 * that are sent.
 *
 * @package Inc\Database
 */
class DbImage extends DbModel {
    // database name
    static $tableName = "image";

    /**
     * In that function, called from the Init class,
     * permit to create the database.
     */
    public function register() {

    }

    public static function insert($url) {
        $data = array(
            "path" => $url,
        );

        // Check if exist
        if(!($image = self::get($data, "OBJECT"))) {
            $data = array(
                "path" => $url,
                "dateCreation" => self::now()
            );

            if(parent::insert($data)){
                $data = array(
                    "path" => $url,
                );
                $image = self::get($data, "OBJECT");
                return $image->id;
            } else {
                return null;
            }
        } else {
            return $image->id;
        }
    }


}