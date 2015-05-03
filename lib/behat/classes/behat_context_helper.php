<?php

/**
 * Helper to initialise behat contexts from lion code.
 *
 * @package    core
 * @category   test
 * @copyright  2014 2015 Pooya Saeedi
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

use Behat\Mink\Session as Session,
    Behat\Mink\Mink as Mink;

/**
 * Helper to get behat contexts.
 *
 * @package    core
 * @category   test
 * @copyright  2014 2015 Pooya Saeedi
 * 
 */
class behat_context_helper {

    /**
     * List of already initialized contexts.
     *
     * @var array
     */
    protected static $contexts = array();

    /**
     * @var Mink.
     */
    protected static $mink = false;

    /**
     * Sets the browser session.
     *
     * @param Session $session
     * @return void
     */
    public static function set_session(Session $session) {

        // Set mink to be able to init a context.
        self::$mink = new Mink(array('mink' => $session));
        self::$mink->setDefaultSessionName('mink');
    }

    /**
     * Gets the required context.
     *
     * Getting a context you get access to all the steps
     * that uses direct API calls; steps returning step chains
     * can not be executed like this.
     *
     * @throws coding_exception
     * @param string $classname Context identifier (the class name).
     * @return behat_base
     */
    public static function get($classname) {

        if (!self::init_context($classname)) {
            throw coding_exception('The required "' . $classname . '" class does not exist');
        }

        return self::$contexts[$classname];
    }

    /**
     * Initializes the required context.
     *
     * @throws coding_exception
     * @param string $classname
     * @return bool
     */
    protected static function init_context($classname) {

        if (!empty(self::$contexts[$classname])) {
            return true;
        }

        if (!class_exists($classname)) {
            return false;
        }

        $instance = new $classname();
        $instance->setMink(self::$mink);

        self::$contexts[$classname] = $instance;

        return true;
    }

}
