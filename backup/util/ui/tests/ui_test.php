<?php

/**
 * Contains user interface tests.
 *
 * @package   core
 * @subpackage backup
 * @category phpunit
 * @copyright 2015 Pooya Saeedi
 */

// Note:
// Renaming required

defined('MOODLE_INTERNAL') || die();

// Include all the needed stuff.
global $CFG;
//require_once($CFG->dirroot . '/backup/util/checks/backup_check.class.php');

/**
 * ui tests (all)
 *
 * @package   core_backup
 * @copyright 2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_ui_testcase extends basic_testcase {

    /**
     * Test backup_ui class
     */
    public function test_backup_ui() {
    }
}
