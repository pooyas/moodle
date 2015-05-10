<?php

/**
 * Provides support for the conversion of lion1 backup to the lion2 format
 *
 * @package    mod
 * @subpackage book
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Book conversion handler
 */
class lion1_mod_book_handler extends lion1_mod_handler {

    /** @var lion1_file_manager */
    protected $fileman = null;

    /** @var int cmid */
    protected $moduleid = null;

    /**
     * Declare the paths in lion.xml we are able to convert
     *
     * The method returns list of {@link convert_path} instances. For each path returned,
     * at least one of on_xxx_start(), process_xxx() and on_xxx_end() methods must be
     * defined. The method process_xxx() is not executed if the associated path element is
     * empty (i.e. it contains none elements or sub-paths only).
     *
     * Note that the path /LION_BACKUP/COURSE/MODULES/MOD/BOOK does not
     * actually exist in the file. The last element with the module name was
     * appended by the lion1_converter class.
     *
     * @return array of {@link convert_path} instances
     */
    public function get_paths() {
        return array(
            new convert_path('book', '/LION_BACKUP/COURSE/MODULES/MOD/BOOK',
                    array(
                        'renamefields' => array(
                            'summary' => 'intro',
                        ),
                        'newfields' => array(
                            'introformat' => FORMAT_LION,
                        ),
                        'dropfields' => array(
                            'disableprinting'
                        ),
                    )
                ),
            new convert_path('book_chapters', '/LION_BACKUP/COURSE/MODULES/MOD/BOOK/CHAPTERS/CHAPTER',
                    array(
                        'newfields' => array(
                            'contentformat' => FORMAT_HTML,
                        ),
                    )
                ),
        );
    }

    /**
     * This is executed every time we have one /LION_BACKUP/COURSE/MODULES/MOD/BOOK
     * data available
     * @param array $data
     */
    public function process_book($data) {
        global $CFG;

        // get the course module id and context id
        $instanceid     = $data['id'];
        $cminfo         = $this->get_cminfo($instanceid);
        $this->moduleid = $cminfo['id'];
        $contextid      = $this->converter->get_contextid(CONTEXT_MODULE, $this->moduleid);

        // replay the upgrade step 2009042006
        if ($CFG->texteditors !== 'textarea') {
            $data['intro']       = text_to_html($data['intro'], false, false, true);
            $data['introformat'] = FORMAT_HTML;
        }

        // get a fresh new file manager for this instance
        $this->fileman = $this->converter->get_file_manager($contextid, 'mod_book');

        // convert course files embedded into the intro
        $this->fileman->filearea = 'intro';
        $this->fileman->itemid   = 0;
        $data['intro'] = lion1_converter::migrate_referenced_files($data['intro'], $this->fileman);

        // start writing book.xml
        $this->open_xml_writer("activities/book_{$this->moduleid}/book.xml");
        $this->xmlwriter->begin_tag('activity', array('id' => $instanceid, 'moduleid' => $this->moduleid,
            'modulename' => 'book', 'contextid' => $contextid));
        $this->xmlwriter->begin_tag('book', array('id' => $instanceid));

        foreach ($data as $field => $value) {
            if ($field <> 'id') {
                $this->xmlwriter->full_tag($field, $value);
            }
        }
    }

    /**
     * This is executed every time we have one /LION_BACKUP/COURSE/MODULES/MOD/BOOK/CHAPTERS/CHAPTER
     * data available
     * @param array $data
     */
    public function process_book_chapters($data) {
        // Convert chapter files.
        $this->fileman->filearea = 'chapter';
        $this->fileman->itemid   = $data['id'];
        $data['content'] = lion1_converter::migrate_referenced_files($data['content'], $this->fileman);

        $this->write_xml('chapter', $data, array('/chapter/id'));
    }

    /**
     * This is executed when the parser reaches the <CHAPTERS> opening element
     */
    public function on_book_chapters_start() {
        $this->xmlwriter->begin_tag('chapters');
    }

    /**
     * This is executed when the parser reaches the closing </CHAPTERS> element
     */
    public function on_book_chapters_end() {
        $this->xmlwriter->end_tag('chapters');
    }

    /**
     * This is executed when we reach the closing </MOD> tag of our 'book' path
     */
    public function on_book_end() {
        // finalize book.xml
        $this->xmlwriter->end_tag('book');
        $this->xmlwriter->end_tag('activity');
        $this->close_xml_writer();

        // write inforef.xml
        $this->open_xml_writer("activities/book_{$this->moduleid}/inforef.xml");
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
