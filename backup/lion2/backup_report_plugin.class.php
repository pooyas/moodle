<?php

defined('LION_INTERNAL') || die();

/**
 * Base class for report backup plugins.
 *
 * NOTE: When you back up a course, it potentially may run backup for all
 * reports. In order to control whether a particular report gets
 * backed up, a report should make use of the second and third
 * parameters in get_plugin_element().
 *
 * @package     backup
 * @subpackage  lion2
 * @copyright   2015 Pooya Saeedi
 * 
 */
abstract class backup_report_plugin extends backup_plugin {
    // Use default parent behaviour
}
