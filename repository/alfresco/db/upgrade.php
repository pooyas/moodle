<?php

/**
 * Upgrade.
 *
 * @package    repository
 * @subpackage alfresco
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Upgrade function.
 *
 * @param int $oldversion the version we are upgrading from.
 * @return bool result
 */
function xmldb_repository_alfresco_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2014020301) {
        require_once($CFG->dirroot . '/repository/lib.php');
        require_once($CFG->dirroot . '/repository/alfresco/db/upgradelib.php');

        $params = array();
        $params['context'] = array();
        $params['onlyvisible'] = false;
        $params['type'] = 'alfresco';
        $instances = repository::get_instances($params);

        // Notify the admin about the migration process if they are using the repo.
        if (!empty($instances)) {
            repository_alfresco_admin_security_key_notice();
        }

        upgrade_plugin_savepoint(true, 2014020301, 'repository', 'alfresco');
    }

    // Lion v2.7.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
