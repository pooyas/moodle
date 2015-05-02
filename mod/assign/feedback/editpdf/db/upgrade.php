<?php

/**
 * Upgrade code for the feedback_editpdf module.
 *
 * @package   assignfeedback_editpdf
 * @copyright 2013 Jerome Mouneyrac
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * EditPDF upgrade code
 * @param int $oldversion
 * @return bool
 */
function xmldb_assignfeedback_editpdf_upgrade($oldversion) {
    global $CFG;

    if ($oldversion < 2013110800) {

        // Check that no stamps where uploaded.
        $fs = get_file_storage();
        $stamps = $fs->get_area_files(context_system::instance()->id, 'assignfeedback_editpdf',
            'stamps', 0, "filename", false);

        // Add default stamps.
        if (empty($stamps)) {
            // List of default stamps.
            $defaultstamps = array('smile.png', 'sad.png', 'tick.png', 'cross.png');

            // Stamp file object.
            $filerecord = new stdClass;
            $filerecord->component = 'assignfeedback_editpdf';
            $filerecord->contextid = context_system::instance()->id;
            $filerecord->userid    = get_admin()->id;
            $filerecord->filearea  = 'stamps';
            $filerecord->filepath  = '/';
            $filerecord->itemid    = 0;

            // Add all default stamps.
            foreach ($defaultstamps as $stamp) {
                $filerecord->filename = $stamp;
                $fs->create_file_from_pathname($filerecord,
                    $CFG->dirroot . '/mod/assign/feedback/editpdf/pix/' . $filerecord->filename);
            }
        }

        upgrade_plugin_savepoint(true, 2013110800, 'assignfeedback', 'editpdf');
    }

    // Lion v2.6.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.7.0 release upgrade line.
    // Put any upgrade step following this.

    // Lion v2.8.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
