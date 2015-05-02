<?php

/**
 * The mod_book course module viewed event.
 *
 * @package    mod_book
 * @copyright  2013 Frédéric Massart
 * 
 */

namespace mod_book\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_book course module viewed event class.
 *
 * @package    mod_book
 * @since      Lion 2.6
 * @copyright  2013 Frédéric Massart
 * 
 */
class course_module_viewed extends \core\event\course_module_viewed {
    /**
     * Create instance of event.
     *
     * @since Lion 2.7
     *
     * @param \stdClass $book
     * @param \context_module $context
     * @return course_module_viewed
     */
    public static function create_from_book(\stdClass $book, \context_module $context) {
        $data = array(
            'context' => $context,
            'objectid' => $book->id
        );
        /** @var course_module_viewed $event */
        $event = self::create($data);
        $event->add_record_snapshot('book', $book);
        return $event;
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
