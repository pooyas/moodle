<?php


/**
 * Export db content to file.
 *
 * @package    admin_tool
 * @subpackage dbtransfer
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;
/*

TODO:
  - exporting to server file >2GB fails in 32bit operating systems - needs warning
  - we may run out of disk space exporting to server file - we must verify the file is not truncated; read from the end of file?
  - when sending file >4GB - FAT32 limit, Apache limit, browser limit - needs warning
  - there must be some form of progress bar during export, transfer - new tracking class could be passed around
  - command line operation - could work around some 2G/4G limits in PHP; useful for cron full backups
  - by default allow exporting into empty database only (no tables with the same prefix yet)
  - all dangerous operation (like deleting of all data) should be confirmed by key found in special file in dataroot
    (user would need file access to dataroot which might prevent various "accidents")
  - implement "Export/import running" notification in lib/setup.php (similar to new upgrade flag in config table)
  - gzip compression when storing xml file - the xml is very verbose and full of repeated tags (zip is not suitable here at all)
    this could help us keep the files below 2G (expected ratio is > 10:1)

*/

require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/dtllib.php');

/**
 * Initiate database export.
 * @param string $description
 * @param lion_database $mdb
 * @return does not return, calls die()
 */
function tool_dbtransfer_export_xml_database($description, $mdb) {
    core_php_time_limit::raise();

    \core\session\manager::write_close(); // Release session.

    header('Content-Type: application/xhtml+xml; charset=utf-8');
    header('Content-Disposition: attachment; filename=database.xml');
    header('Expires: 0');
    header('Cache-Control: must-revalidate,post-check=0,pre-check=0');
    header('Pragma: public');

    while(@ob_flush());

    $var = new file_xml_database_exporter('php://output', $mdb);
    $var->export_database($description);

    // No more output.
    die;
}

/**
 * Initiate database transfer.
 * @param lion_database $sourcedb
 * @param lion_database $targetdb
 * @param progress_trace $feedback
 * @return void
 */
function tool_dbtransfer_transfer_database(lion_database $sourcedb, lion_database $targetdb, progress_trace $feedback = null) {
    core_php_time_limit::raise();

    \core\session\manager::write_close(); // Release session.

    $var = new database_mover($sourcedb, $targetdb, true, $feedback);
    $var->export_database(null);

    tool_dbtransfer_rebuild_target_log_actions($targetdb, $feedback);
}

/**
 * Very hacky function for rebuilding of log actions in target database.
 * @param lion_database $target
 * @param progress_trace $feedback
 * @return void
 * @throws Exception on conversion error
 */
function tool_dbtransfer_rebuild_target_log_actions(lion_database $target, progress_trace $feedback = null) {
    global $DB, $CFG;
    require_once("$CFG->libdir/upgradelib.php");

    $feedback->output(get_string('convertinglogdisplay', 'tool_dbtransfer'));

    $olddb = $DB;
    $DB = $target;
    try {
        $DB->delete_records('log_display', array('component'=>'lion'));
        log_update_descriptions('lion');
        $plugintypes = core_component::get_plugin_types();
        foreach ($plugintypes as $type => $location) {
            $plugs = core_component::get_plugin_list($type);
            foreach ($plugs as $plug => $fullplug) {
                $component = $type.'_'.$plug;
                $DB->delete_records('log_display', array('component'=>$component));
                log_update_descriptions($component);
            }
        }
    } catch (Exception $e) {
        $DB = $olddb;
        throw $e;
    }
    $DB = $olddb;
    $feedback->output(get_string('done', 'core_dbtransfer', null), 1);
}

/**
 * Returns list of fully working database drivers present in system.
 * @return array
 */
function tool_dbtransfer_get_drivers() {
    global $CFG;

    $files = new RegexIterator(new DirectoryIterator("$CFG->libdir/dml"), '|^.*_lion_database\.php$|');
    $drivers = array();

    foreach ($files as $file) {
        $matches = null;
        preg_match('|^([a-z0-9]+)_([a-z]+)_lion_database\.php$|', $file->getFilename(), $matches);
        if (!$matches) {
            continue;
        }
        $dbtype = $matches[1];
        $dblibrary = $matches[2];

        if ($dbtype === 'sqlite3') {
            // Blacklist unfinished drivers.
            continue;
        }

        $targetdb = lion_database::get_driver_instance($dbtype, $dblibrary, false);
        if ($targetdb->driver_installed() !== true) {
            continue;
        }

        $driver = $dbtype.'/'.$dblibrary;

        $drivers[$driver] = $targetdb->get_name();
    };

    return $drivers;
}

/**
 * Create CLI maintenance file to prevent all access.
 */
function tool_dbtransfer_create_maintenance_file() {
    global $CFG;

    core_shutdown_manager::register_function('tool_dbtransfer_maintenance_callback');

    $options = new stdClass();
    $options->trusted = false;
    $options->noclean = false;
    $options->smiley = false;
    $options->filter = false;
    $options->para = true;
    $options->newlines = false;

    $message = format_text(get_string('climigrationnotice', 'tool_dbtransfer'), FORMAT_MARKDOWN, $options);
    $message = bootstrap_renderer::early_error_content($message, '', '', array());
    $html = <<<OET
<!DOCTYPE html>
<html>
<header><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><header/>
<body>$message</body>
</html>
OET;

    file_put_contents("$CFG->dataroot/climaintenance.html", $html);
    @chmod("$CFG->dataroot/climaintenance.html", $CFG->filepermissions);
}

/**
 * This callback is responsible for unsetting maintenance mode
 * if the migration is interrupted.
 */
function tool_dbtransfer_maintenance_callback() {
    global $CFG;

    if (empty($CFG->tool_dbransfer_migration_running)) {
        // Migration was finished properly - keep the maintenance file in place.
        return;
    }

    if (file_exists("$CFG->dataroot/climaintenance.html")) {
        // Failed migration, revert to normal site operation.
        unlink("$CFG->dataroot/climaintenance.html");
        error_log('tool_dbtransfer: Interrupted database migration detected, switching off CLI maintenance mode.');
    }
}
