<?php


/**
 * Provides support for the conversion of lion1 backup to the lion2 format
 *
 * @package    mod
 * @subpackage data
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Database conversion handler
 */
class lion1_mod_data_handler extends lion1_mod_handler {

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
     * Note that the path /LION_BACKUP/COURSE/MODULES/MOD/DATA does not
     * actually exist in the file. The last element with the module name was
     * appended by the lion1_converter class.
     *
     * @return array of {@link convert_path} instances
     */
    public function get_paths() {
        return array(
            new convert_path('data', '/LION_BACKUP/COURSE/MODULES/MOD/DATA',
                        array(
                            'newfields' => array(
                                'introformat' => 0,
                                'assesstimestart' => 0,
                                'assesstimefinish' => 0,
                            )
                        )
                    ),
            new convert_path('data_field', '/LION_BACKUP/COURSE/MODULES/MOD/DATA/FIELDS/FIELD')
        );
    }

    /**
     * This is executed every time we have one /LION_BACKUP/COURSE/MODULES/MOD/DATA
     * data available
     */
    public function process_data($data) {
        global $CFG;

        // get the course module id and context id
        $instanceid     = $data['id'];
        $cminfo         = $this->get_cminfo($instanceid);
        $this->moduleid = $cminfo['id'];
        $contextid      = $this->converter->get_contextid(CONTEXT_MODULE, $this->moduleid);

        // replay the upgrade step 2007101512
        if (!array_key_exists('asearchtemplate', $data)) {
            $data['asearchtemplate'] = null;
        }

        // replay the upgrade step 2007101513
        if (is_null($data['notification'])) {
            $data['notification'] = 0;
        }

        // conditionally migrate to html format in intro
        if ($CFG->texteditors !== 'textarea') {
            $data['intro'] = text_to_html($data['intro'], false, false, true);
            $data['introformat'] = FORMAT_HTML;
        }

        // get a fresh new file manager for this instance
        $this->fileman = $this->converter->get_file_manager($contextid, 'mod_data');

        // convert course files embedded into the intro
        $this->fileman->filearea = 'intro';
        $this->fileman->itemid   = 0;
        $data['intro'] = lion1_converter::migrate_referenced_files($data['intro'], $this->fileman);

        // @todo: user data - upgrade content to new file storage

        // add 'export' tag to list and single template.
        $pattern = '/\#\#delete\#\#(\s+)\#\#approve\#\#/';
        $replacement = '##delete##$1##approve##$1##export##';
        $data['listtemplate'] = preg_replace($pattern, $replacement, $data['listtemplate']);
        $data['singletemplate'] = preg_replace($pattern, $replacement, $data['singletemplate']);

        //@todo: user data - move data comments to comments table
        //@todo: user data - move data ratings to ratings table

        // start writing data.xml
        $this->open_xml_writer("activities/data_{$this->moduleid}/data.xml");
        $this->xmlwriter->begin_tag('activity', array('id' => $instanceid, 'moduleid' => $this->moduleid,
            'modulename' => 'data', 'contextid' => $contextid));
        $this->xmlwriter->begin_tag('data', array('id' => $instanceid));

        foreach ($data as $field => $value) {
            if ($field <> 'id') {
                $this->xmlwriter->full_tag($field, $value);
            }
        }

        $this->xmlwriter->begin_tag('fields');

        return $data;
    }

    /**
     * This is executed every time we have one /LION_BACKUP/COURSE/MODULES/MOD/DATA/FIELDS/FIELD
     * data available
     */
    public function process_data_field($data) {
        // process database fields
        $this->write_xml('field', $data, array('/field/id'));
    }

    /**
     * This is executed every time we have one /LION_BACKUP/COURSE/MODULES/MOD/DATA/RECORDS/RECORD
     * data available
     */
    public function process_data_record($data) {
        //@todo process user data, and define the convert path in get_paths() above.
        //$this->write_xml('record', $data, array('/record/id'));
    }

    /**
     * This is executed when we reach the closing </MOD> tag of our 'data' path
     */
    public function on_data_end() {
        // finish writing data.xml
        $this->xmlwriter->end_tag('fields');
        $this->xmlwriter->end_tag('data');
        $this->xmlwriter->end_tag('activity');
        $this->close_xml_writer();

        // write inforef.xml
        $this->open_xml_writer("activities/data_{$this->moduleid}/inforef.xml");
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
