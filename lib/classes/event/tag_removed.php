<?php

/**
 * The tag removed event.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Event class for when a tag has been removed from an item.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int tagid: the id of the tag.
 *      - string tagname: the name of the tag.
 *      - string tagrawname: the raw name of the tag.
 *      - int itemid: the id of the item tagged.
 *      - string itemtype: the type of item tagged.
 * }
 *
 */
class tag_removed extends base {

    /**
     * Initialise the event data.
     */
    protected function init() {
        $this->data['objecttable'] = 'tag_instance';
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventtagremoved', 'tag');
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' removed the tag with id '{$this->other['tagid']}' from the item type '" .
            s($this->other['itemtype']) . "' with id '{$this->other['itemid']}'.";
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception when validation does not pass.
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['tagid'])) {
            throw new \coding_exception('The \'tagid\' value must be set in other.');
        }

        if (!isset($this->other['itemid'])) {
            throw new \coding_exception('The \'itemid\' value must be set in other.');
        }

        if (!isset($this->other['itemtype'])) {
            throw new \coding_exception('The \'itemtype\' value must be set in other.');
        }

        if (!isset($this->other['tagname'])) {
            throw new \coding_exception('The \'tagname\' value must be set in other.');
        }

        if (!isset($this->other['tagrawname'])) {
            throw new \coding_exception('The \'tagrawname\' value must be set in other.');
        }
    }
}
