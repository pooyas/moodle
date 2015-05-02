<?php


/**
 * Defines backup_theme_plugin class
 *
 * @package     core_backup
 * @subpackage  lion2
 * @category    backup
 * @copyright   2011 onwards The Open University
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('LION_INTERNAL') || die();

/**
 * Base class for theme backup plugins.
 *
 * NOTE: When you back up a course, it runs backup for ALL themes - not just
 * the currently selected one.
 *
 * That means that if, for example, a course was once in theme A, and theme A
 * had some data settings, but it is then changed to theme B, the data settings
 * will still be included in the backup and restore. With the restored course,
 * if you ever change it back to theme A, the settings will be ready.
 *
 * It also means that other themes which are not the one set up for the course,
 * but might be seen by some users (eg user themes, session themes, mnet themes)
 * can store data.
 *
 * If this behaviour is not desired for a particular theme's data, the subclass
 * can call is_current_theme('myname') to check.
 */
abstract class backup_theme_plugin extends backup_plugin {

    /**
     * @var string Current theme for course (may not be the same as plugin).
     */
    protected $coursetheme;

    /**
     * @param string $plugintype Plugin type (always 'theme')
     * @param string $pluginname Plugin name (name of theme)
     * @param backup_optigroup $optigroup Group that will contain this data
     * @param backup_course_structure_step $step Backup step that this is part of
     */
    public function __construct($plugintype, $pluginname, $optigroup, $step) {

        parent::__construct($plugintype, $pluginname, $optigroup, $step);

        $this->coursetheme = backup_plan_dbops::get_theme_from_courseid(
                    $this->task->get_courseid());

    }

    /**
     * Return condition for whether this theme should be backed up (= if it
     * is the same theme as the one used in this course). This condition has
     * the theme used in the course. It will be compared against the name
     * of the theme, by use of third parameter in get_plugin_element; in
     * subclass, you should do:
     * $plugin = $this->get_plugin_element(null, $this->get_theme_condition(), 'mytheme');
     */
    protected function get_theme_condition() {
        return array('sqlparam' => $this->coursetheme);
    }
}
