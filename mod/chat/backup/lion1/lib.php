<?php


/**
 * Provides support for the conversion of lion1 backup to the lion2 format
 * Based off of a template @ http://docs.lion.org/dev/Backup_1.9_conversion_for_developers
 *
 * @package    mod
 * @subpackage chat
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Chat conversion handler
 */
class lion1_mod_chat_handler extends lion1_mod_handler {

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
     * Note that the path /LION_BACKUP/COURSE/MODULES/MOD/CHAT does not
     * actually exist in the file. The last element with the module name was
     * appended by the lion1_converter class.
     *
     * @return array of {@link convert_path} instances
     */
    public function get_paths() {
        return array(
            new convert_path(
                'chat', '/LION_BACKUP/COURSE/MODULES/MOD/CHAT',
                array(
                    'newfields' => array(
                        'introformat' => 0
                    )
                )
            )
        );
    }

    /**
     * This is executed every time we have one /LION_BACKUP/COURSE/MODULES/MOD/CHAT
     * data available
     */
    public function process_chat($data) {
        global $CFG;

        // Get the course module id and context id.
        $instanceid     = $data['id'];
        $cminfo         = $this->get_cminfo($instanceid);
        $this->moduleid = $cminfo['id'];
        $contextid      = $this->converter->get_contextid(CONTEXT_MODULE, $this->moduleid);

        // Replay the upgrade step 2010050101.
        if ($CFG->texteditors !== 'textarea') {
            $data['intro']       = text_to_html($data['intro'], false, false, true);
            $data['introformat'] = FORMAT_HTML;
        }

        // Get a fresh new file manager for this instance.
        $this->fileman = $this->converter->get_file_manager($contextid, 'mod_chat');

        // Convert course files embedded into the intro.
        $this->fileman->filearea = 'intro';
        $this->fileman->itemid   = 0;
        $data['intro'] = lion1_converter::migrate_referenced_files($data['intro'], $this->fileman);

        // Start writing chat.xml.
        $this->open_xml_writer("activities/chat_{$this->moduleid}/chat.xml");
        $this->xmlwriter->begin_tag('activity', array('id' => $instanceid, 'moduleid' => $this->moduleid,
            'modulename' => 'chat', 'contextid' => $contextid));
        $this->xmlwriter->begin_tag('chat', array('id' => $instanceid));

        foreach ($data as $field => $value) {
            if ($field <> 'id') {
                $this->xmlwriter->full_tag($field, $value);
            }
        }

        $this->xmlwriter->begin_tag('messages');

        return $data;
    }

    /**
     * This is executed every time we have one /LION_BACKUP/COURSE/MODULES/MOD/CHAT/MESSAGES/MESSAGE
     * data available
     */
    public function process_chat_message($data) {
        // MDL-46466 - Should this be empty?
    }

    /**
     * This is executed when we reach the closing </MOD> tag of our 'chat' path
     */
    public function on_chat_end() {
        // Close chat.xml.
        $this->xmlwriter->end_tag('messages');
        $this->xmlwriter->end_tag('chat');
        $this->xmlwriter->end_tag('activity');
        $this->close_xml_writer();

        // Write inforef.xml.
        $this->open_xml_writer("activities/chat_{$this->moduleid}/inforef.xml");
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
