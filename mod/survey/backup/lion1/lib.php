<?php



/**
 * Provides support for the conversion of lion1 backup to the lion2 format
 *
 * @package    mod
 * @subpackage survey
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Survey conversion handler
 */
class lion1_mod_survey_handler extends lion1_mod_handler {

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
     * Note that the path /LION_BACKUP/COURSE/MODULES/MOD/SURVEY does not
     * actually exist in the file. The last element with the module name was
     * appended by the lion1_converter class.
     *
     * @return array of {@link convert_path} instances
     */
    public function get_paths() {
        return array(
            new convert_path(
                'survey', '/LION_BACKUP/COURSE/MODULES/MOD/SURVEY',
                array(
                    'newfields' => array(
                        'introformat' => 0,
                    ),
                )
            ),
        );
    }

    /**
     * This is executed every time we have one /LION_BACKUP/COURSE/MODULES/MOD/SURVEY
     * data available
     */
    public function process_survey($data) {
        global $CFG;

        // get the course module id and context id
        $instanceid     = $data['id'];
        $cminfo         = $this->get_cminfo($instanceid);
        $this->moduleid = $cminfo['id'];
        $contextid      = $this->converter->get_contextid(CONTEXT_MODULE, $this->moduleid);

        // replay upgrade step 2009042002
        if ($CFG->texteditors !== 'textarea') {
            $data['intro']       = text_to_html($data['intro'], false, false, true);
            $data['introformat'] = FORMAT_HTML;
        }

        // get a fresh new file manager for this instance
        $this->fileman = $this->converter->get_file_manager($contextid, 'mod_survey');

        // convert course files embedded into the intro
        $this->fileman->filearea = 'intro';
        $this->fileman->itemid   = 0;
        $data['intro'] = lion1_converter::migrate_referenced_files($data['intro'], $this->fileman);

        // write survey.xml
        $this->open_xml_writer("activities/survey_{$this->moduleid}/survey.xml");
        $this->xmlwriter->begin_tag('activity', array('id' => $instanceid, 'moduleid' => $this->moduleid,
            'modulename' => 'survey', 'contextid' => $contextid));
        $this->xmlwriter->begin_tag('survey', array('id' => $instanceid));

        foreach ($data as $field => $value) {
            if ($field <> 'id') {
                $this->xmlwriter->full_tag($field, $value);
            }
        }

        return $data;
    }

    /**
     * This is executed when we reach the closing </MOD> tag of our 'survey' path
     */
    public function on_survey_end() {
        // finish survey.xml
        $this->xmlwriter->end_tag('survey');
        $this->xmlwriter->end_tag('activity');
        $this->close_xml_writer();

        // write inforef.xml
        $this->open_xml_writer("activities/survey_{$this->moduleid}/inforef.xml");
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
