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

    const DEFAULT_CAT = array(
        "title" => "Default",
        "slug" => "default",
    );

    /**
     * Insert a new category and retrieve the id.
     *
     * @param array $data category to be insert.
     *
     * @return int id of the new row.
     */
    public static function insert($data) {
        $category = null;

        // If doesn't exist
        if (!($category = self::get($data, "OBJECT"))) {
            $idRow = parent::insert($data);
            return $idRow;
        } else {
            return $category->id;
        }
    }


    /**
     * Delete a category.
     *
     * @param int $id of the category.
     *
     * @return bool|null true everything good, false errors, null you're trying to
     *                   delete the default category.
     */
    public static function delete($id) {
        $where = ["idCategory" => $id];
        $products = DbProduct::get($where, 'object');

        // check if there are product with that category
        if ($products) {
            $defaultCat = DbCategory::get(["slug" => self::DEFAULT_CAT['slug']], 'object');

            // we need to create a default category to change the
            // products with the new default category
            if(!$defaultCat) {
                $idDefault = DbCategory::insert(self::DEFAULT_CAT);
            } else if ($defaultCat->id != $id) {
                $idDefault = $defaultCat->id;
            } else {
                return null;
            }

            // change the old id with the new
            foreach ($products as $product) {
                if(!DbProduct::update(["idCategory" => $idDefault], ["id" => $product->id])) {
                    // if error
                    return false;
                }
            }
        }

        return parent::delete($id);
    }

}