<?php

/**
 * Gradereport user plugin upgrade code
 *
 * @package    gradereport
 * @subpackage user
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_gradereport_user_upgrade($oldversion) {

    if ($oldversion < 2014101500) {
        // Need to always show weight and contribution to course total.
        set_config('grade_report_user_showweight', 1);

        // User savepoint reached.
        upgrade_plugin_savepoint(true, 2014101500, 'gradereport', 'user');
    }

    return true;
}
