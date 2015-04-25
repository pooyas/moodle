<?php

/**
 * @package     core
 * @subpackage backup
 * @copyright   2015 Pooya Saeedi
 */

// Note:
// Renaming required

/**
 * Collection of helper functions to handle files
 *
 * This class implements various functions related with lion storage
 * handling (get file from storage, put it there...) and some others
 * to use the zip/unzip facilities.
 *
 * Note: It's supposed that, some day, files implementation will offer
 * those functions without needeing to know storage internals at all.
 * That day, we'll move related functions here to proper file api ones.
 *
 * TODO: Finish phpdocs
 */
class backup_file_manager {

    /**
     * Returns the full path to backup storage base dir
     */
    public static function get_backup_storage_base_dir($backupid) {
        global $CFG;

        return $CFG->tempdir . '/backup/' . $backupid . '/files';
    }

    /**
     * Given one file content hash, returns the path (relative to filedir)
     * to the file.
     */
    public static function get_backup_content_file_location($contenthash) {
        $l1 = $contenthash[0].$contenthash[1];
        return "$l1/$contenthash";
    }

    /**
     * Copy one file from lion storage to backup storage
     */
    public static function copy_file_moodle2backup($backupid, $filerecorid) {
        global $DB;

        if (!backup_controller_dbops::backup_includes_files($backupid)) {
            // Only include the files if required by the controller.
            return;
        }

        // Normalise param
        if (!is_object($filerecorid)) {
            $filerecorid = $DB->get_record('files', array('id' => $filerecorid));
        }

        // Directory, nothing to do
        if ($filerecorid->filename === '.') {
            return;
        }

        $fs = get_file_storage();
        $file = $fs->get_file_instance($filerecorid);
        // If the file is external file, skip copying.
        if ($file->is_external_file()) {
            return;
        }

        // Calculate source and target paths (use same subdirs strategy for both)
        $targetfilepath = self::get_backup_storage_base_dir($backupid) . '/' .
                          self::get_backup_content_file_location($filerecorid->contenthash);

        // Create target dir if necessary
        if (!file_exists(dirname($targetfilepath))) {
            if (!check_dir_exists(dirname($targetfilepath), true, true)) {
                throw new backup_helper_exception('cannot_create_directory', dirname($targetfilepath));
            }
        }

        // And copy the file (if doesn't exist already)
        if (!file_exists($targetfilepath)) {
            $file->copy_content_to($targetfilepath);
        }
    }
}
