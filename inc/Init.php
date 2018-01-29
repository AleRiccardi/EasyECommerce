<?php
/**
 * Initial class that is called.
 *
 * @author      Alessandro RICCARDI
 * @since       1.0.0
 *
 * @package     OpenBadgesFramework
 */

namespace Inc;


/**
 * This is the initial class that is called from WordPress.
 * Here will start all the initial class that we want to execute.
 *
 * @author      Alessandro RICCARDI
 * @since       1.0.0
 */
final class Init {

    /**
     * Store all the classes inside an array.
     *
     * @author      Alessandro RICCARDI
     * @since       1.0.0
     *
     * @return array Full list of classes
     */
    public static function getServices() {
        return array(
            Base\BaseController::class,
            Utils\Login::class,
            Utils\Registration::class,
            Utils\User::class,
            Utils\Address::class,
            Utils\Category::class,
            Utils\Item::class,
            Utils\Checkout::class,
            Utils\Order::class,
            Base\Redirect::class,

        );
    }

    /**
     * Loop through the classes, initialize them,
     * and call the register() method if it exists.
     *
     * @author      Alessandro RICCARDI
     * @since       1.0.0
     */
    public static function registerServices() {
        foreach (self::getServices() as $class) {
            $service = self::instantiate($class);

            if (method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    /**
     * Initialize the class.
     *
     * @author      Alessandro RICCARDI
     * @since       1.0.0
     *
     * @param class $class class form services array
     *
     * @return class instance   new instance of the class
     */
    private static function instantiate($class) {
        return new $class();
    }

}
