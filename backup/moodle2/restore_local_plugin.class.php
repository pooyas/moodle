<?php

/**
 * Defines restore_local_plugin class
 *
 * @package     core
 * @subpackage backup
 * @copyright   2015 Pooya Saeedi
 */

// Note:
// Renaming required

defined('MOODLE_INTERNAL') || die();

/**
 * Class extending standard restore_plugin in order to implement some
 * helper methods related with local plugins
 */
abstract class restore_local_plugin extends restore_plugin {}