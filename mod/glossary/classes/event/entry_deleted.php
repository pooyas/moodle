<?php


/**
 * The mod_glossary entry deleted event.
 *
 * @package    mod
 * @subpackage glossary
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_glossary\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_glossary entry deleted event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string concept: (optional) the concept of deleted entry.
 *      - string mode: (optional) view mode user was in before deleting entry.
 *      - int|string hook: (optional) hook parameter in the previous view mode.
 * }
 *
 */
class entry_deleted extends \core\event\base {
    /**
     * Init method
     */
    protected function init() {
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'glossary_entries';
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('evententrydeleted', 'mod_glossary');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has deleted the glossary entry with id '$this->objectid' in " .
            "the glossary activity with course module id '$this->contextinstanceid'.";
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        // Entry does not exist any more, returning link to the module view page in the mode it was before deleting entry.
        $params = array('id' => $this->contextinstanceid);
        if (isset($this->other['hook'])) {
            $params['hook'] = $this->other['hook'];
        }
        if (isset($this->other['mode'])) {
            $params['mode'] = $this->other['mode'];
        }
        return new \lion_url("/mod/glossary/view.php", $params);
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    public function get_legacy_logdata() {
        $hook = $mode = '';
        if (isset($this->other['hook'])) {
            $hook = $this->other['hook'];
        }
        if (isset($this->other['mode'])) {
            $mode = $this->other['mode'];
        }
        return array($this->courseid, 'glossary', 'delete entry',
            "view.php?id={$this->contextinstanceid}&amp;mode={$mode}&amp;hook={$hook}",
            $this->objectid, $this->contextinstanceid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        // Make sure this class is never used without proper object details.
        if (!$this->contextlevel === CONTEXT_MODULE) {
            throw new \coding_exception('Context level must be CONTEXT_MODULE.');
        }
    }
}

