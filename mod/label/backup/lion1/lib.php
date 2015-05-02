<?php


/**
 * Provides support for the conversion of lion1 backup to the lion2 format
 * Based off of a template @ http://docs.lion.org/dev/Backup_1.9_conversion_for_developers
 *
 * @package mod_label
 * @copyright  2011 Aparup Banerjee <aparup@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Label conversion handler
 */
class lion1_mod_label_handler extends lion1_mod_handler {

    /**
     * Declare the paths in lion.xml we are able to convert
     *
     * The method returns list of {@link convert_path} instances.
     * For each path returned, the corresponding conversion method must be
     * defined.
     *
     * Note that the path /LION_BACKUP/COURSE/MODULES/MOD/LABEL does not
     * actually exist in the file. The last element with the module name was
     * appended by the lion1_converter class.
     *
     * @return array of {@link convert_path} instances
     */
    public function get_paths() {
        return array(
            new convert_path(
                'label', '/LION_BACKUP/COURSE/MODULES/MOD/LABEL',
                array(
                    'renamefields' => array(
                        'content' => 'intro'
                    ),
                    'newfields' => array(
                        'introformat' => FORMAT_HTML
                    )
                )
            )
        );
    }

    /**
     * This is executed every time we have one /LION_BACKUP/COURSE/MODULES/MOD/LABEL
     * data available
     */
    public function process_label($data) {
        // get the course module id and context id
        $instanceid = $data['id'];
        $cminfo     = $this->get_cminfo($instanceid);
        $moduleid   = $cminfo['id'];
        $contextid  = $this->converter->get_contextid(CONTEXT_MODULE, $moduleid);

        // get a fresh new file manager for this instance
        $fileman = $this->converter->get_file_manager($contextid, 'mod_label');

        // convert course files embedded into the intro
        $fileman->filearea = 'intro';
        $fileman->itemid   = 0;
        $data['intro'] = lion1_converter::migrate_referenced_files($data['intro'], $fileman);

        // write inforef.xml
        $this->open_xml_writer("activities/label_{$moduleid}/inforef.xml");
        $this->xmlwriter->begin_tag('inforef');
        $this->xmlwriter->begin_tag('fileref');
        foreach ($fileman->get_fileids() as $fileid) {
            $this->write_xml('file', array('id' => $fileid));
        }
        $this->xmlwriter->end_tag('fileref');
        $this->xmlwriter->end_tag('inforef');
        $this->close_xml_writer();

        // write label.xml
        $this->open_xml_writer("activities/label_{$moduleid}/label.xml");
        $this->xmlwriter->begin_tag('activity', array('id' => $instanceid, 'moduleid' => $moduleid,
            'modulename' => 'label', 'contextid' => $contextid));
        $this->write_xml('label', $data, array('/label/id'));
        $this->xmlwriter->end_tag('activity');
        $this->close_xml_writer();

        return $data;
    }
}
