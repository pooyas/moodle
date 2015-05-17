<?php


/**
 * booktool_print book printed event.
 *
 * @package    mod
 * @subpackage book
 * @copyright  2015 Pooya Saeedi
 */

namespace booktool_print\event;
defined('LION_INTERNAL') || die();

/**
 * booktool_print book printed event class.
 *
 */
class book_printed extends \core\event\base {
    /**
     * Create instance of event.
     *
     *
     * @param \stdClass $book
     * @param \context_module $context
     * @return book_printed
     */
    public static function create_from_book(\stdClass $book, \context_module $context) {
        $data = array(
            'context' => $context,
            'objectid' => $book->id
        );
        /** @var book_printed $event */
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
        return "The user with id '$this->userid' has printed the book with course module id '$this->contextinstanceid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'book', 'print', 'tool/print/index.php?id=' . $this->contextinstanceid,
            $this->objectid, $this->contextinstanceid);
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventbookprinted', 'booktool_print');
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
