<?php

/**
 * The mod_lesson highscore added event.
 *
 * @package    mod_lesson
 * @copyright  2013 2015 Pooya Saeedi
 * .
 */

namespace mod_lesson\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_lesson highscore added event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int lessonid: the id of the lesson in the lesson table.
 *      - string nickname: the user's nickname.
 * }
 *
 * @package    mod_lesson
 * @since      Lion 2.7
 * @copyright  2013 2015 Pooya Saeedi
 * .
 */

class highscore_added extends \core\event\base {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['objecttable'] = 'lesson_high_scores';
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventhighscoreadded', 'mod_lesson');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/lesson/highscores.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' added a new highscore to the lesson activity with course module " .
            "id '$this->contextinstanceid'.";
    }

    /**
     * Replace add_to_log() statement.
     *
     * @return array of parameters to be passed to legacy add_to_log() function.
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'lesson', 'update highscores', 'highscores.php?id=' . $this->contextinstanceid,
            $this->other['nickname'], $this->contextinstanceid);
    }

    /**
     * Custom validations.
     *
     * @throws \coding_exception when validation fails.
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['lessonid'])) {
            throw new \coding_exception('The \'lessonid\' value must be set in other.');
        }

        if (!isset($this->other['nickname'])) {
            throw new \coding_exception('The \'nickname\' value must be set in other.');
        }
    }
}
