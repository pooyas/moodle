<?php

/**
 * booktool_print chapter printed event.
 *
 * @package    booktool
 * @subpackage print
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace booktool_print\event;
defined('LION_INTERNAL') || die();

/**
 * booktool_print chapter printed event class.
 *
 */
class chapter_printed extends \core\event\base {
    /**
     * Create instance of event.
     *
     * @since Lion 2.7
     *
     * @param \stdClass $book
     * @param \context_module $context
     * @param \stdClass $chapter
     * @return chapter_printed
     */
    public static function create_from_chapter(\stdClass $book, \context_module $context, \stdClass $chapter) {
        $data = array(
            'context' => $context,
            'objectid' => $chapter->id,
        );
        /** @var chapter_printed $event */
        $event = self::create($data);
        $event->add_record_snapshot('book', $book);
        $event->add_record_snapshot('book_chapters', $chapter);
        return $event;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has printed the chapter with id '$this->objectid' of the book with " .
            "course module id '$this->contextinstanceid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'book', 'print chapter', 'tool/print/index.php?id=' . $this->contextinstanceid .
            '&chapterid=' . $this->objectid, $this->objectid, $this->contextinstanceid);
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventchapterprinted', 'booktool_print');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/book/tool/print/index.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'book';
    }

}
