<?php


/**
 * MYSQL specific temptables store. Needed because temporary tables
 * are named differently than normal tables. Also used to be able to retrieve
 * temp table names included in the get_tables() method of the DB.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

require_once(__DIR__.'/lion_temptables.php');

class mysqli_native_lion_temptables extends lion_temptables {
    // I love these classes :-P
}
