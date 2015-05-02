<?php

/**
 * The mod_book chapter viewed event.
 *
 * @package    mod_book
 * @copyright  2013 Frédéric Massart
 * 
 */

namespace mod_book\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_book chapter viewed event class.
 *
 * @package    mod_book
 * @since      Lion 2.6
 * @copyright  2013 Frédéric Massart
 * 
 */
class chapter_viewed extends \core\event\base {
    /**
     * Create instance of event.
     *
     * @since Lion 2.7
     *
     * @param \stdClass $book
     * @param \context_module $context
     * @param \stdClass $chapter
     * @return chapter_viewed
     */
    public static function create_from_chapter(\stdClass $book, \context_module $context, \stdClass $chapter) {
        $data = array(
            'context' => $context,
            'objectid' => $chapter->id,
        );
        /** @var chapter_viewed $event */
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
        return "The user with id '$this->userid' viewed the chapter with id '$this->objectid' for the book with " .
            "course module id '$this->contextinstanceid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'book', 'view chapter', 'view.php?id=' . $this->contextinstanceid .
            '&amp;chapterid=' . $this->objectid, $this->objectid, $this->contextinstanceid);
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventchapterviewed', 'mod_book');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/book/view.php', array('id' => $this->contextinstanceid, 'chapterid' => $this->objectid));
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'book_chapters';
    }
}
