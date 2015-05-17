<?php



/**
 * Provides support for the conversion of lion1 backup to the lion2 format
 *
 * @package    mod
 * @subpackage forum
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Forum conversion handler
 */
class lion1_mod_forum_handler extends lion1_mod_handler {

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
     * Note that the paths /LION_BACKUP/COURSE/MODULES/MOD/FORUM do not
     * actually exist in the file. The last element with the module name was
     * appended by the lion1_converter class.
     *
     * @return array of {@link convert_path} instances
     */
    public function get_paths() {
        return array(
            new convert_path('forum', '/LION_BACKUP/COURSE/MODULES/MOD/FORUM',
                array(
                    'renamefields' => array(
                        'format' => 'messageformat',
                    ),
                    'newfields' => array(
                        'completiondiscussions' => 0,
                        'completionreplies' => 0,
                        'completionpost' => 0,
                        'maxattachments' => 1,
                        'introformat' => 0,
                    ),
                )
            ),
        );
    }

    /**
     * Converts /LION_BACKUP/COURSE/MODULES/MOD/FORUM data
     */
    public function process_forum($data) {
        global $CFG;

        // get the course module id and context id
        $instanceid     = $data['id'];
        $cminfo         = $this->get_cminfo($instanceid);
        $this->moduleid = $cminfo['id'];
        $contextid      = $this->converter->get_contextid(CONTEXT_MODULE, $this->moduleid);

        // get a fresh new file manager for this instance
        $this->fileman = $this->converter->get_file_manager($contextid, 'mod_forum');

        // convert course files embedded into the intro
        $this->fileman->filearea = 'intro';
        $this->fileman->itemid   = 0;
        $data['intro'] = lion1_converter::migrate_referenced_files($data['intro'], $this->fileman);

        // Convert the introformat if necessary.
        if ($CFG->texteditors !== 'textarea') {
            $data['intro'] = text_to_html($data['intro'], false, false, true);
            $data['introformat'] = FORMAT_HTML;
        }

        // start writing forum.xml
        $this->open_xml_writer("activities/forum_{$this->moduleid}/forum.xml");
        $this->xmlwriter->begin_tag('activity', array('id' => $instanceid, 'moduleid' => $this->moduleid,
            'modulename' => 'forum', 'contextid' => $contextid));
        $this->xmlwriter->begin_tag('forum', array('id' => $instanceid));

        foreach ($data as $field => $value) {
            if ($field <> 'id') {
                $this->xmlwriter->full_tag($field, $value);
            }
        }

        $this->xmlwriter->begin_tag('discussions');

        return $data;
    }

    /**
     * This is executed when we reach the closing </MOD> tag of our 'forum' path
     */
    public function on_forum_end() {
        // finish writing forum.xml
        $this->xmlwriter->end_tag('discussions');
        $this->xmlwriter->end_tag('forum');
        $this->xmlwriter->end_tag('activity');
        $this->close_xml_writer();

        // write inforef.xml
        $this->open_xml_writer("activities/forum_{$this->moduleid}/inforef.xml");
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
