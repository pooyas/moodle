<?php


/**
 * Provides support for the conversion of lion1 backup to the lion2 format
 *
 * @package    mod
 * @subpackage feedback
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Feedback module conversion handler
 */
class lion1_mod_feedback_handler extends lion1_mod_handler {

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
     * Note that the path /LION_BACKUP/COURSE/MODULES/MOD/FEEDBACK does not
     * actually exist in the file. The last element with the module name was
     * appended by the lion1_converter class.
     *
     * @return array of {@link convert_path} instances
     */
    public function get_paths() {
        return array(
            new convert_path(
                'feedback', '/LION_BACKUP/COURSE/MODULES/MOD/FEEDBACK',
                array(
                    'renamefields' => array(
                        'summary' => 'intro',
                        'pageaftersub' => 'page_after_submit',
                    ),
                    'newfields' => array(
                        'autonumbering' => 1,
                        'site_after_submit' => '',
                        'introformat' => 0,
                        'page_after_submitformat' => 0,
                        'completionsubmit' => 0,
                    ),
                )
            ),
            new convert_path(
                'feedback_item', '/LION_BACKUP/COURSE/MODULES/MOD/FEEDBACK/ITEMS/ITEM',
                array (
                    'newfields' => array(
                        'label' => '',
                        'options' => '',
                        'dependitem' => 0,
                        'dependvalue' => '',
                    ),
                )
            ),
        );
    }

    /**
     * This is executed every time we have one /LION_BACKUP/COURSE/MODULES/MOD/FEEDBACK
     * data available
     */
    public function process_feedback($data) {
        global $CFG;

        // get the course module id and context id
        $instanceid     = $data['id'];
        $cminfo         = $this->get_cminfo($instanceid);
        $this->moduleid = $cminfo['id'];
        $contextid      = $this->converter->get_contextid(CONTEXT_MODULE, $this->moduleid);

        // get a fresh new file manager for this instance
        $this->fileman = $this->converter->get_file_manager($contextid, 'mod_feedback');

        // convert course files embedded into the intro
        $this->fileman->filearea = 'intro';
        $this->fileman->itemid   = 0;
        $data['intro'] = lion1_converter::migrate_referenced_files($data['intro'], $this->fileman);

        // Convert the introformat if necessary.
        if ($CFG->texteditors !== 'textarea') {
            $data['intro'] = text_to_html($data['intro'], false, false, true);
            $data['introformat'] = FORMAT_HTML;
        }

        // start writing feedback.xml
        $this->open_xml_writer("activities/feedback_{$this->moduleid}/feedback.xml");
        $this->xmlwriter->begin_tag('activity', array('id' => $instanceid, 'moduleid' => $this->moduleid,
            'modulename' => 'feedback', 'contextid' => $contextid));
        $this->xmlwriter->begin_tag('feedback', array('id' => $instanceid));

        foreach ($data as $field => $value) {
            if ($field <> 'id') {
                $this->xmlwriter->full_tag($field, $value);
            }
        }

        $this->xmlwriter->begin_tag('items');

        return $data;
    }

    /**
     * This is executed every time we have one /LION_BACKUP/COURSE/MODULES/MOD/FEEDBACK/ITEMS/ITEM
     * data available
     */
    public function process_feedback_item($data) {
        $this->write_xml('item', $data, array('/item/id'));
    }

    /**
     * This is executed when we reach the closing </MOD> tag of our 'feedback' path
     */
    public function on_feedback_end() {
        // finish writing feedback.xml
        $this->xmlwriter->end_tag('items');
        $this->xmlwriter->end_tag('feedback');
        $this->xmlwriter->end_tag('activity');
        $this->close_xml_writer();

        // write inforef.xml
        $this->open_xml_writer("activities/feedback_{$this->moduleid}/inforef.xml");
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
