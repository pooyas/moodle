<?php


/**
 * Defines restore_local_plugin class
 *
 * @package    core_backup
 * @subpackage lion2
 * @category   backup
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Class extending standard restore_plugin in order to implement some
 * helper methods related with local plugins
 */
abstract class restore_local_plugin extends restore_plugin {}