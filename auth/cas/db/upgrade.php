<?php

/**
 * CAS authentication plugin upgrade code
 *
 * @package    auth
 * @subpackage cas
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_auth_cas_upgrade($oldversion) {


    // MDL-39323 New setting in 2.5, make sure it's defined.
    if ($oldversion < 2013052100) {
        if (get_config('start_tls', 'auth/cas') === false) {
            set_config('start_tls', 0, 'auth/cas');
        }
        upgrade_plugin_savepoint(true, 2013052100, 'auth', 'cas');
    }

    if ($oldversion < 2013091700) {
        // The value of the phpCAS language constants has changed from
        // 'langname' to 'CAS_Languages_Langname'.
        if ($cas_language = get_config('auth/cas', 'language')) {
            set_config('language', 'CAS_Languages_'.ucfirst($cas_language), 'auth/cas');
        }

        upgrade_plugin_savepoint(true, 2013091700, 'auth', 'cas');
    }

    return true;
}
