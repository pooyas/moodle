<?php


/**
 * Provides support for the conversion of lion1 backup to the lion2 format
 *
 * @package    mod_folder
 * @copyright  2011 Andrew Davis <andrew@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Folder conversion handler. This resource handler is called by lion1_mod_resource_handler
 */
class lion1_mod_folder_handler extends lion1_resource_successor_handler {

    /** @var lion1_file_manager instance */
    protected $fileman = null;

    /**
     * Converts /LION_BACKUP/COURSE/MODULES/MOD/RESOURCE data
     * Called by lion1_mod_resource_handler::process_resource()
     */
    public function process_legacy_resource(array $data, array $raw = null) {
        // get the course module id and context id
        $instanceid     = $data['id'];
        $currentcminfo  = $this->get_cminfo($instanceid);
        $moduleid       = $currentcminfo['id'];
        $contextid      = $this->converter->get_contextid(CONTEXT_MODULE, $moduleid);

        // convert legacy data into the new folder record
        $folder                 = array();
        $folder['id']           = $data['id'];
        $folder['name']         = $data['name'];
        $folder['intro']        = $data['intro'];
        $folder['introformat']  = $data['introformat'];
        $folder['revision']     = 1;
        $folder['timemodified'] = $data['timemodified'];

        // get a fresh new file manager for this instance
        $this->fileman = $this->converter->get_file_manager($contextid, 'mod_folder');

        // migrate the files embedded into the intro field
        $this->fileman->filearea = 'intro';
        $this->fileman->itemid   = 0;
        $folder['intro'] = lion1_converter::migrate_referenced_files($folder['intro'], $this->fileman);

        // migrate the folder files
        $this->fileman->filearea = 'content';
        $this->fileman->itemid   = 0;
        if (empty($data['reference'])) {
            $this->fileman->migrate_directory('course_files');
        } else {
            $this->fileman->migrate_directory('course_files/'.$data['reference']);
        }

        // write folder.xml
        $this->open_xml_writer("activities/folder_{$moduleid}/folder.xml");
        $this->xmlwriter->begin_tag('activity', array('id' => $instanceid, 'moduleid' => $moduleid,
            'modulename' => 'folder', 'contextid' => $contextid));
        $this->write_xml('folder', $folder, array('/folder/id'));
        $this->xmlwriter->end_tag('activity');
        $this->close_xml_writer();

        // write inforef.xml
        $this->open_xml_writer("activities/folder_{$moduleid}/inforef.xml");
        $this->xmlwriter->begin_tag('inforef');
        $this->xmlwriter->begin_tag('fileref');
        foreach ($this->fileman->get_fileids() as $fileid) {
            $this->write_xml('file', array('id' => $fileid));
        }
        $this->xmlwriter->end_tag('fileref');
        $this->xmlwriter->end_tag('inforef');
        $this->close_xml_writer();
    }
}
