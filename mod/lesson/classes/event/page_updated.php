<?php


/**
 * The mod_lesson page_added event class.
 *
 * @package    mod
 * @subpackage lesson
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_lesson\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_lesson page_updated event class.
 * @property-read array $other {
 * Extra information about event.
 *
 * - string pagetype: the name of the pagetype as defined in the individual page class
 * }
 *
 */
class page_updated extends \core\event\base {

    /**
     * Create instance of event.
     *
     * @param \lesson_page $lessonpage
     * @param \context_module $context
     * @return page_updated
     */
    public static function create_from_lesson_page(\lesson_page $lessonpage, \context_module $context) {
        $data = array(
            'context' => $context,
            'objectid' => $lessonpage->properties()->id,
            'other' => array(
                'pagetype' => $lessonpage->get_typestring()
            )
        );
        return self::create($data);
    }


    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['objecttable'] = 'lesson_pages';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventpageupdated', 'mod_lesson');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/lesson/view.php', array('id' => $this->contextinstanceid, 'pageid' => $this->objectid));
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has updated the ".$this->other['pagetype']." page with the ".
                "id '$this->objectid' in the lesson activity with course module id '$this->contextinstanceid'.";
    }

    /**
     * Custom validations.
     *
     * @throws \coding_exception when validation fails.
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        // Make sure this class is never used without proper object details.
        if (!$this->contextlevel === CONTEXT_MODULE) {
            throw new \coding_exception('Context level must be CONTEXT_MODULE.');
        }
        if (!isset($this->other['pagetype'])) {
            throw new \coding_exception('The \'pagetype\' value must be set in other.');
        }
    }
}