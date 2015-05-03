<?php


/**
 * Provides support for the conversion of lion1 backup to the lion2 format
 *
 * @package    mod_choice
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Choice conversion handler
 */
class lion1_mod_choice_handler extends lion1_mod_handler {

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
     * Note that the path /LION_BACKUP/COURSE/MODULES/MOD/CHOICE does not
     * actually exist in the file. The last element with the module name was
     * appended by the lion1_converter class.
     *
     * @return array of {@link convert_path} instances
     */
    public function get_paths() {
        return array(
            new convert_path(
                'choice', '/LION_BACKUP/COURSE/MODULES/MOD/CHOICE',
                array(
                    'renamefields' => array(
                        'text' => 'intro',
                        'format' => 'introformat',
                    ),
                    'newfields' => array(
                        'completionsubmit' => 0,
                    ),
                    'dropfields' => array(
                        'modtype'
                    ),
                )
            ),
            new convert_path('choice_options', '/LION_BACKUP/COURSE/MODULES/MOD/CHOICE/OPTIONS'),
            new convert_path('choice_option', '/LION_BACKUP/COURSE/MODULES/MOD/CHOICE/OPTIONS/OPTION'),
        );
    }

    /**
     * This is executed every time we have one /LION_BACKUP/COURSE/MODULES/MOD/CHOICE
     * data available
     */
    public function process_choice($data) {

        // get the course module id and context id
        $instanceid     = $data['id'];
        $cminfo         = $this->get_cminfo($instanceid);
        $this->moduleid = $cminfo['id'];
        $contextid      = $this->converter->get_contextid(CONTEXT_MODULE, $this->moduleid);

        // get a fresh new file manager for this instance
        $this->fileman = $this->converter->get_file_manager($contextid, 'mod_choice');

        // convert course files embedded into the intro
        $this->fileman->filearea = 'intro';
        $this->fileman->itemid   = 0;
        $data['intro'] = lion1_converter::migrate_referenced_files($data['intro'], $this->fileman);

        // start writing choice.xml
        $this->open_xml_writer("activities/choice_{$this->moduleid}/choice.xml");
        $this->xmlwriter->begin_tag('activity', array('id' => $instanceid, 'moduleid' => $this->moduleid,
            'modulename' => 'choice', 'contextid' => $contextid));
        $this->xmlwriter->begin_tag('choice', array('id' => $instanceid));

        foreach ($data as $field => $value) {
            if ($field <> 'id') {
                $this->xmlwriter->full_tag($field, $value);
            }
        }

        return $data;
    }

    /**
     * This is executed when the parser reaches the <OPTIONS> opening element
     */
    public function on_choice_options_start() {
        $this->xmlwriter->begin_tag('options');
    }

    /**
     * This is executed every time we have one /LION_BACKUP/COURSE/MODULES/MOD/CHOICE/OPTIONS/OPTION
     * data available
     */
    public function process_choice_option($data) {
        $this->write_xml('option', $data, array('/option/id'));
    }

    /**
     * This is executed when the parser reaches the closing </OPTIONS> element
     */
    public function on_choice_options_end() {
        $this->xmlwriter->end_tag('options');
    }

    /**
     * This is executed when we reach the closing </MOD> tag of our 'choice' path
     */
    public function on_choice_end() {
        // finalize choice.xml
        $this->xmlwriter->end_tag('choice');
        $this->xmlwriter->end_tag('activity');
        $this->close_xml_writer();

        // write inforef.xml
        $this->open_xml_writer("activities/choice_{$this->moduleid}/inforef.xml");
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
