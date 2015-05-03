<?php

/**
 * Provides support for the conversion of lion1 backup to the lion2 format
 *
 * @package mod_imscp
 * @copyright  2015 Pooya Saeedi <andrew@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * imscp conversion handler. This resource handler is called by lion1_mod_resource_handler
 *
 * @copyright  2015 Pooya Saeedi <andrew@lion.com>
 * 
 */
class lion1_mod_imscp_handler extends lion1_resource_successor_handler {

    /** @var lion1_file_manager the file manager instance */
    protected $fileman = null;

    /**
     * Converts /LION_BACKUP/COURSE/MODULES/MOD/RESOURCE data
     * Called by lion1_mod_resource_handler::process_resource()
     */
    public function process_legacy_resource(array $data, array $raw = null) {

        $instanceid    = $data['id'];
        $currentcminfo = $this->get_cminfo($instanceid);
        $moduleid      = $currentcminfo['id'];
        $contextid     = $this->converter->get_contextid(CONTEXT_MODULE, $moduleid);

        // Prepare the new imscp instance record.
        $imscp                  = array();
        $imscp['id']            = $data['id'];
        $imscp['name']          = $data['name'];
        $imscp['intro']         = $data['intro'];
        $imscp['introformat']   = $data['introformat'];
        $imscp['revision']      = 1;
        $imscp['keepold']       = 1;
        $imscp['structure']     = null;
        $imscp['timemodified']  = $data['timemodified'];

        // Prepare a fresh new file manager for this instance.
        $this->fileman = $this->converter->get_file_manager($contextid, 'mod_imscp');

        // Convert course files embedded into the intro.
        $this->fileman->filearea = 'intro';
        $this->fileman->itemid   = 0;
        $imscp['intro'] = lion1_converter::migrate_referenced_files($imscp['intro'], $this->fileman);

        // Migrate package backup file.
        if ($data['reference']) {
            $packagename = basename($data['reference']);
            $packagepath = $this->converter->get_tempdir_path().'/moddata/resource/'.$data['id'].'/'.$packagename;
            if (file_exists($packagepath)) {
                $this->fileman->filearea = 'backup';
                $this->fileman->itemid   = 1;
                $this->fileman->migrate_file('moddata/resource/'.$data['id'].'/'.$packagename);
            } else {
                $this->log('missing imscp package', backup::LOG_WARNING, 'moddata/resource/'.$data['id'].'/'.$packagename);
            }
        }

        // Migrate extracted package data.
        $this->fileman->filearea = 'content';
        $this->fileman->itemid   = 1;
        $this->fileman->migrate_directory('moddata/resource/'.$data['id']);

        // Parse manifest.
        $structure = $this->parse_structure($this->converter->get_tempdir_path().
                    '/moddata/resource/'.$data['id'].'/imsmanifest.xml', $imscp, $contextid);
        $imscp['structure'] = is_array($structure) ? serialize($structure) : null;

        // Write imscp.xml.
        $this->open_xml_writer("activities/imscp_{$moduleid}/imscp.xml");
        $this->xmlwriter->begin_tag('activity', array('id' => $instanceid, 'moduleid' => $moduleid,
            'modulename' => 'imscp', 'contextid' => $contextid));
        $this->write_xml('imscp', $imscp, array('/imscp/id'));
        $this->xmlwriter->end_tag('activity');
        $this->close_xml_writer();

        // Write inforef.xml.
        $this->open_xml_writer("activities/imscp_{$moduleid}/inforef.xml");
        $this->xmlwriter->begin_tag('inforef');
        $this->xmlwriter->begin_tag('fileref');
        foreach ($this->fileman->get_fileids() as $fileid) {
            $this->write_xml('file', array('id' => $fileid));
        }
        $this->xmlwriter->end_tag('fileref');
        $this->xmlwriter->end_tag('inforef');
        $this->close_xml_writer();
    }

    // Internal implementation details follow.

    /**
     * Parse the IMS package structure for the $imscp->structure field
     *
     * @param string $manifestfilepath the full path to the manifest file to parse
     */
    protected function parse_structure($manifestfilepath, $imscp, $context) {
        global $CFG;

        if (!file_exists($manifestfilepath)) {
            $this->log('missing imscp manifest file', backup::LOG_WARNING);
            return null;
        }
        $manifestfilecontents = file_get_contents($manifestfilepath);
        if (empty($manifestfilecontents)) {
            $this->log('empty imscp manifest file', backup::LOG_WARNING);
            return null;
        }

        require_once($CFG->dirroot.'/mod/imscp/locallib.php');
        return imscp_parse_manifestfile($manifestfilecontents, $imscp, $context);
    }
}
