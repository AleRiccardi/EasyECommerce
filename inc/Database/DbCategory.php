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

    public static function get(array $where, $output) {
        if (!isset($where["available"])) $where["available"] = 1;
        return parent::get($where, $output);
    }

    public static function getSingle(array $where, $output) {
        if (!isset($where["available"])) $where["available"] = 1;
        return parent::getSingle($where, $output);
    }

    public static function getAll($type, array $where = null) {
        if (!isset($where["available"])) $where["available"] = 1;
        return parent::getAll($type, $where);
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
        $products = DbItem::get($where, 'object');

        // check if there are product with that category
        if ($products) {
            $defaultCat = DbCategory::getSingle(["slug" => self::DEFAULT_CAT['slug']], 'object');

            // we need to create a default category to change the
            // products with the new default category
            if (!$defaultCat) {
                $idDefault = DbCategory::insert(self::DEFAULT_CAT);
            } else if ($defaultCat->id != $id) {
                $idDefault = $defaultCat->id;
            } else {
                return null;
            }

            // change the old id with the new
            foreach ($products as $product) {
                if (!DbItem::update(["idCategory" => $idDefault], ["id" => $product->id])) {
                    // if error
                    return false;
                }
            }
        }

        return parent::update(["available" => 0], ["id" => $id]);
    }

    public static function getFiltered(array $filter, $where, $output) {
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