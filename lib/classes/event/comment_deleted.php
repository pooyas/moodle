<?php


/**
 * Abstract comment deleted event.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Abstract comment deleted event class.
 *
 * This class has to be extended by any event which is triggred while deleting comment.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int itemid: id of item for which comment is deleted.
 * }
 *
 */
abstract class comment_deleted extends base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'comments';
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcommentdeleted', 'lion');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' deleted the comment with id '$this->objectid' from the '$this->component' " .
            "with course module id '$this->contextinstanceid'.";
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        $context = $this->get_context();
        if ($context) {
            return $context->get_url();
        } else {
            return null;
        }
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->other['itemid'])) {
            throw new \coding_exception('The \'itemid\' value must be set in other.');
        }
    }
}
