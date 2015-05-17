<?php


/**
 * 1.9 to 2.0 backup format converter. (Also currently used in common cartridge import process)
 *
 * @package    mod
 * @subpackage lti
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

class lion1_mod_lti_handler extends lion1_mod_handler {

    /** @var lion1_file_manager */
    protected $fileman = null;

    /** @var int cmid */
    protected $moduleid = null;

    /**
     * Declare the paths in lion.xml we are able to convert
     *
     * The method returns list of {@link convert_path} instances.
     * For each path returned, the corresponding conversion method must be
     * defined.
     *
     * Note that the path /LION_BACKUP/COURSE/MODULES/MOD/LTI does not
     * actually exist in the file. The last element with the module name was
     * appended by the lion1_converter class.
     *
     * @return array of {@link convert_path} instances
     */
    public function get_paths() {

        return array(
            new convert_path(
                'basiclti', '/LION_BACKUP/COURSE/MODULES/MOD/LTI'
            )
        );

    }

    /**
     * This is executed every time we have one /LION_BACKUP/COURSE/MODULES/MOD/LTI
     * data available
     */
    public function process_basiclti($data) {
        global $DB;

        // Get the course module id and context id.
        $instanceid     = $data['id'];
        $cminfo         = $this->get_cminfo($instanceid);
        $this->moduleid = $cminfo['id'];
        $contextid      = $this->converter->get_contextid(CONTEXT_MODULE, $this->moduleid);

        // Get a fresh new file manager for this instance.
        $this->fileman = $this->converter->get_file_manager($contextid, 'mod_lti');

        // Convert course files embedded into the intro.
        $this->fileman->filearea = 'intro';
        $this->fileman->itemid   = 0;
        $data['intro'] = lion1_converter::migrate_referenced_files($data['intro'], $this->fileman);

        // Start writing assignment.xml.
        $this->open_xml_writer("activities/lti_{$this->moduleid}/lti.xml");
        $this->xmlwriter->begin_tag('activity', array('id' => $instanceid, 'moduleid' => $this->moduleid,
                'modulename' => 'lti', 'contextid' => $contextid));
        $this->xmlwriter->begin_tag('lti', array('id' => $instanceid));

        $ignorefields = array('id', 'modtype');
        if (!$DB->record_exists('lti_types', array('id' => $data['typeid']))) {
            $ntypeid = $DB->get_field('lti_types_config',
                                      'typeid',
                                      array('name' => 'toolurl', 'value' => $data['toolurl']),
                                      IGNORE_MULTIPLE);
            if ($ntypeid === false) {
                $ntypeid = $DB->get_field('lti_types_config',
                                          'typeid',
                                          array(),
                                          IGNORE_MULTIPLE);

            }
            if ($ntypeid === false) {
                $ntypeid = 0;
            }
            $data['typeid'] = $ntypeid;
        }
        if (empty($data['servicesalt'])) {
            $data['servicesalt'] = uniqid('', true);
        }
        foreach ($data as $field => $value) {
            if (!in_array($field, $ignorefields)) {
                $this->xmlwriter->full_tag($field, $value);
            }
        }

        return $data;
    }

    /**
     * This is executed when we reach the closing </MOD> tag of our 'lti' path
     */
    public function on_basiclti_end() {
        // Finish writing basiclti.xml.
        $this->xmlwriter->end_tag('lti');
        $this->xmlwriter->end_tag('activity');
        $this->close_xml_writer();

        // Write inforef.xml.
        $this->open_xml_writer("activities/lti_{$this->moduleid}/inforef.xml");
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

