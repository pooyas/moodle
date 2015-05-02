<?php

/**
 * Provides an overview of installed reports
 *
 * Displays the list of found reports, their version (if found) and
 * a link to uninstall the report.
 *
 * The code is based on admin/localplugins.php by David Mudrak.
 *
 * @package   admin
 * @copyright 2011 Petr Skoda {@link http://skodak.org}
 * 
 */

require_once(dirname(__FILE__) . '/../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/tablelib.php');

admin_externalpage_setup('managereports');

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('reports'));

/// Print the table of all installed report plugins

$struninstall = get_string('uninstallplugin', 'core_admin');

$table = new flexible_table('reportplugins_administration_table');
$table->define_columns(array('name', 'logstoressupported', 'version', 'uninstall'));
$table->define_headers(array(get_string('plugin'), get_string('logstoressupported', 'admin'), get_string('version'),
        $struninstall));
$table->define_baseurl($PAGE->url);
$table->set_attribute('id', 'reportplugins');
$table->set_attribute('class', 'admintable generaltable');
$table->setup();

$plugins = array();
foreach (core_component::get_plugin_list('report') as $plugin => $plugindir) {
    if (get_string_manager()->string_exists('pluginname', 'report_' . $plugin)) {
        $strpluginname = get_string('pluginname', 'report_' . $plugin);
    } else {
        $strpluginname = $plugin;
    }
    $plugins[$plugin] = $strpluginname;
}
core_collator::asort($plugins);

$like = $DB->sql_like('plugin', '?', true, true, false, '|');
$params = array('report|_%');
$installed = $DB->get_records_select('config_plugins', "$like AND name = 'version'", $params);
$versions = array();
foreach ($installed as $config) {
    $name = preg_replace('/^report_/', '', $config->plugin);
    $versions[$name] = $config->value;
    if (!isset($plugins[$name])) {
        $plugins[$name] = $name;
    }
}

$logmanager = get_log_manager();

foreach ($plugins as $plugin => $name) {
    $uninstall = '';
    if ($uninstallurl = core_plugin_manager::instance()->get_uninstall_url('report_'.$plugin, 'manage')) {
        $uninstall = html_writer::link($uninstallurl, $struninstall);
    }

    $stores = $logmanager->get_supported_logstores('report_' . $plugin);
    if ($stores === false) {
        $supportedstores = get_string('logstorenotrequired', 'admin');
    } else if (!empty($stores)) {
        $supportedstores = implode(', ', $stores);
    } else {
        $supportedstores = get_string('nosupportedlogstore', 'admin');;
    }

    if (!isset($versions[$plugin])) {
        if (file_exists("$CFG->dirroot/report/$plugin/version.php")) {
            // not installed yet
            $version = '?';
        } else {
            // no version info available
            $version = '-';
        }
    } else {
        $version = $versions[$plugin];
        if (file_exists("$CFG->dirroot/report/$plugin")) {
            $version = $versions[$plugin];
        } else {
            // somebody removed plugin without uninstall
            $name = '<span class="notifyproblem">'.$name.' ('.get_string('missingfromdisk').')</span>';
            $version = $versions[$plugin];
        }
    }

    $table->add_data(array($name, $supportedstores, $version, $uninstall));
}

$table->print_html();

echo $OUTPUT->footer();
