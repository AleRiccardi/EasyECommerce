<?php

namespace Inc\Database;

/**
 * That class manage the database table for the badges
 * that are sent.
 *
 * @package Inc\Database
 */
class DbUser extends DbModel {
    const ER_DONT_EXIST = "The badge don't exist.\n";
    const ER_DUPLICATE = "The badge is duplicate.\n";
    const ER_WRONG_FIELDS = "Wrong fields passed in the array.\n";
    const ER_ERROR = "There's an error in the database.\n";
    // database name
    static $tableName = 'users';

    /**
     * In that function, called from the Init class,
     * permit to create the database.
     */
    public function register() {
        /*global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $installed_version = get_option(self::DB_NAME_VERSION);
        if ($installed_version !== self::DB_VERSION) {
            $sql = "CREATE TABLE " . $this->getTableName() . " (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            userEmail varchar(180) NOT NULL,
            badgeId mediumint(9) NOT NULL,
            fieldId mediumint(9) NOT NULL,
            levelId mediumint(9) NOT NULL,
            classId mediumint(9),
            teacherId mediumint(9) NOT NULL,
            roleSlug varchar(50) NOT NULL,
            dateCreation datetime NOT NULL,
            getDate datetime,
            getMobDate datetime,
            json varchar(64) NOT NULL,
            info text,
            evidence varchar(1500),
            UNIQUE KEY  (userEmail, badgeId, fieldId, levelId)
        ) $charset_collate;";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
            update_option(self::DB_NAME_VERSION, self::DB_VERSION);
        }*/
    }

    /**
     * Get it.
     *
     * @param array|null $data
     * @param string     $type
     *
     * @return array|null
     */
    public static function get(array $data = null, $type = "OBJECT") {
        return parent::get($data, $type);
    }

    /**
     * Get all the badge.
     *
     * @author      Alessandro RICCARDI
     * @since       1.0.0
     *
     * @return string
     */
    public static function getAll() {
        return parent::get();
    }

    /**
     * Get all the badge.
     *
     * @author      Alessandro RICCARDI
     * @since       1.0.0
     *
     * @return array of badges
     */
    public static function getKeys() {
        $data = parent::get();
        return $data ? $data[0] : array();
    }

}