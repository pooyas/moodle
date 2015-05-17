<?php


/**
 * The mod_glossary entry viwed event.
 *
 * @package    mod
 * @subpackage glossary
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_glossary\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_glossary entry viewed event class.
 *
 * Triggered when glossary entry is autolinked and viewed by user from another context.
 *
 */
class entry_viewed extends \core\event\base {
    /**
     * Init method
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'glossary_entries';
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('evententryviewed', 'mod_glossary');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has viewed the glossary entry with id '$this->objectid' in " .
            "the glossary activity with course module id '$this->contextinstanceid'.";
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url("/mod/glossary/showentry.php",
                array('eid' => $this->objectid));
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    public function get_legacy_logdata() {
        return array($this->courseid, 'glossary', 'view entry',
            "showentry.php?eid={$this->objectid}",
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

