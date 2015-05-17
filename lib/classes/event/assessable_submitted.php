<?php


/**
 * Abstract assessable submitted event.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Abstract assessable submitted event class.
 *
 * This class has to be extended by any event which represent that some content,
 * on which someone will be assessed, has been submitted and so made available
 * for grading. See {@link \core\event\assessable_uploaded} for when the content
 * has just been uploaded.
 *
 * Both events could be triggered in a row, first the uploaded, then the submitted.
 *
 */
abstract class assessable_submitted extends base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception on error.
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if ($this->contextlevel != CONTEXT_MODULE) {
            throw new \coding_exception('Context passed must be module context.');
        }
    }

}
