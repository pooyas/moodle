<?php


/**
 * Abstract assessable uploaded event.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Abstract assessable uploaded event class.
 *
 * This class has to be extended by any event which represent that some content,
 * on which someone will be assessed, has been uploaded. This is different
 * than other events such as assessable_submitted, which means that the content
 * has been submitted and made available for grading.
 *
 * Both events could be triggered in a row, first the uploaded, then the submitted.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - array pathnamehashes: uploaded files path name hashes.
 *      - string content: the content.
 * }
 *
 */
abstract class assessable_uploaded extends base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Validation that should be shared among child classes.
     *
     * @throws \coding_exception when validation fails.
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if ($this->contextlevel != CONTEXT_MODULE) {
            throw new \coding_exception('Context level must be CONTEXT_MODULE.');
        } else if (!isset($this->other['pathnamehashes']) || !is_array($this->other['pathnamehashes'])) {
            throw new \coding_exception('The \'pathnamehashes\' value must be set in other and must be an array.');
        } else if (!isset($this->other['content']) || !is_string($this->other['content'])) {
            throw new \coding_exception('The \'content\' value must be set in other and must be a string.');
        }
    }

}
