<?php

/**
 * Email failed event.
 *
 * @package    core
 * @since      Lion 2.7
 * @copyright  2013 Mark Nelson <markn@lion.com>
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Email failed event class.
 *
 * @package    core
 * @since      Lion 2.7
 * @copyright  2013 Mark Nelson <markn@lion.com>
 * 
 */
class email_failed extends base {

    /**
     * Initialise the event data.
     */
    protected function init() {
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventemailfailed');
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "Failed to send an email from the user with id '$this->userid' to the user with id '$this->relateduserid'
            due to the following error: \"{$this->other['errorinfo']}\".";
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array(SITEID, 'library', 'mailer', qualified_me(), 'ERROR: ' . $this->other['errorinfo']);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }
        if (!isset($this->other['subject'])) {
            throw new \coding_exception('The \'subject\' value must be set in other.');
        }
        if (!isset($this->other['message'])) {
            throw new \coding_exception('The \'message\' value must be set in other.');
        }
        if (!isset($this->other['errorinfo'])) {
            throw new \coding_exception('The \'errorinfo\' value must be set in other.');
        }
    }
}
