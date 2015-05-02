<?php


/**
 * Defines backup_format_plugin class
 *
 * @package     core_backup
 * @subpackage  lion2
 * @category    backup
 * @copyright   2011 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('LION_INTERNAL') || die();

/**
 * Class extending standard backup_plugin in order to implement some
 * helper methods related with the course formats (format plugin)
 *
 * TODO: Finish phpdocs
 */
abstract class backup_format_plugin extends backup_plugin {

    protected $courseformat; // To store the format (course->format) of the instance

    public function __construct($plugintype, $pluginname, $optigroup, $step) {

        parent::__construct($plugintype, $pluginname, $optigroup, $step);

        $this->courseformat = backup_plan_dbops::get_courseformat_from_courseid($this->task->get_courseid());

    }

    /**
     * Return the condition encapsulated into sqlparam format
     * to get evaluated by value, not by path nor processor setting
     */
    protected function get_format_condition() {
        return array('sqlparam' => $this->courseformat);
    }
}
