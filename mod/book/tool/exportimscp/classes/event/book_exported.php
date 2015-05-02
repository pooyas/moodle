<?php

/**
 * booktool_exportimscp book exported event.
 *
 * @package    booktool_exportimscp
 * @copyright  2013 Frédéric Massart
 * 
 */

namespace booktool_exportimscp\event;
defined('LION_INTERNAL') || die();

/**
 * booktool_exportimscp book exported event class.
 *
 * @package    booktool_exportimscp
 * @since      Lion 2.6
 * @copyright  2013 Frédéric Massart
 * 
 */
class book_exported extends \core\event\base {
    /**
     * Create instance of event.
     *
     * @since Lion 2.7
     *
     * @param \stdClass $book
     * @param \context_module $context
     * @return book_exported
     */
    public static function create_from_book(\stdClass $book, \context_module $context) {
        $data = array(
            'context' => $context,
            'objectid' => $book->id
        );
        /** @var book_exported $event */
        $event = self::create($data);
        $event->add_record_snapshot('book', $book);
        return $event;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has exported the book with course module id '$this->contextinstanceid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'book', 'exportimscp', 'tool/exportimscp/index.php?id=' . $this->contextinstanceid,
            $this->objectid, $this->contextinstanceid);
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventbookexported', 'booktool_exportimscp');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/book/tool/exportimscp/index.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'book';
    }

}
