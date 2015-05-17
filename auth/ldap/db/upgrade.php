<?php


/**
 * LDAP authentication plugin upgrade code
 *
 * @package    auth
 * @subpackage ldap
 * @copyright  2015 Pooya Saeedi
 */

/**
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_auth_ldap_upgrade($oldversion) {

    // Lion v2.5.0 release upgrade line
    // Put any upgrade step following this

    // MDL-39323 New setting in 2.5, make sure it's defined.
    if ($oldversion < 2013052100) {
        if (get_config('start_tls', 'auth/ldap') === false) {
            set_config('start_tls', 0, 'auth/ldap');
        }
        upgrade_plugin_savepoint(true, 2013052100, 'auth', 'ldap');
    }

    // Lion v2.6.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.7.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
