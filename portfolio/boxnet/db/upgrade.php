<?php

/**
 * Upgrade.
 *
 * @package    portfolio_boxnet
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
function xmldb_portfolio_boxnet_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2013110602) {
        require_once($CFG->libdir . '/portfoliolib.php');
        require_once($CFG->dirroot . '/portfolio/boxnet/db/upgradelib.php');

        $existing = $DB->get_record('portfolio_instance', array('plugin' => 'boxnet'), '*', IGNORE_MULTIPLE);
        if ($existing) {

            // Only disable or message the admins when the portfolio hasn't been set for APIv2.
            $instance = portfolio_instance($existing->id, $existing);
            if ($instance->get_config('clientid') === null && $instance->get_config('clientsecret') === null) {

                // Disable Box.net.
                $instance->set('visible', 0);
                $instance->save();

                // Message the admins.
                portfolio_boxnet_admin_upgrade_notification();
            }
        }

        upgrade_plugin_savepoint(true, 2013110602, 'portfolio', 'boxnet');
    }

    // Lion v2.6.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.7.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
