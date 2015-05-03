<?php

/**
 * @package    core_backup
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

// Include all the needed stuff
global $CFG;
require_once($CFG->dirroot . '/backup/util/interfaces/checksumable.class.php');
require_once($CFG->dirroot . '/backup/backup.class.php');
require_once($CFG->dirroot . '/backup/util/helper/backup_helper.class.php');
require_once($CFG->dirroot . '/backup/util/helper/backup_general_helper.class.php');

/*
 * backup_helper tests (all)
 */
class backup_helper_testcase extends basic_testcase {

    /*
     * test backup_helper class
     */
    function test_backup_helper() {
    }

    /*
     * test backup_general_helper class
     */
    function test_backup_general_helper() {
    }
}
