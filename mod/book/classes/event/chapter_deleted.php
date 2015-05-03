<?php

/**
 * The mod_book chapter deleted event.
 *
 * @package    mod_book
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_book\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_book chapter deleted event class.
 *
 * @package    mod_book
 * @since      Lion 2.6
 * @copyright  2015 Pooya Saeedi
 * 
 */
class chapter_deleted extends \core\event\base {
    /**
     * Create instance of event.
     *
     * @since Lion 2.7
     *
     * @param \stdClass $book
     * @param \context_module $context
     * @param \stdClass $chapter
     * @return chapter_deleted
     */
    public static function create_from_chapter(\stdClass $book, \context_module $context, \stdClass $chapter) {
        $data = array(
            'context' => $context,
            'objectid' => $chapter->id,
        );
        /** @var chapter_deleted $event */
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
        return "The user with id '$this->userid' deleted the chapter with id '$this->objectid' for the book with " .
            "course module id '$this->contextinstanceid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        $chapter = $this->get_record_snapshot('book_chapters', $this->objectid);
        return array($this->courseid, 'book', 'update', 'view.php?id='.$this->contextinstanceid, $chapter->bookid, $this->contextinstanceid);
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventchapterdeleted', 'mod_book');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/book/view.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
        $this->data['objecttable'] = 'book_chapters';
    }
}
