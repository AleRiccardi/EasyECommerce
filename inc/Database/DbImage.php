<?php

namespace Inc\Database;

/**
 * That class manage the database table for the badges
 * that are sent.
 *
 * @package Inc\Database
 */
class DbImage extends DbModel {
    const ER_DONT_EXIST = "The badge don't exist.\n";
    const ER_DUPLICATE = "The badge is duplicate.\n";
    const ER_WRONG_FIELDS = "Wrong fields passed in the array.\n";
    const ER_ERROR = "There's an error in the database.\n";
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
        if(!($image = self::get($data))) {
            $data = array(
                "path" => $url,
                "dateCreation" => self::now()
            );

            if(parent::insert($data)){
                $data = array(
                    "path" => $url,
                );
                $image = self::get($data);
                return $image->id;
            } else {
                return null;
            }
        } else {
            return $image->id;
        }
    }


}