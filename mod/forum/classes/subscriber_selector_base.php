<?php

/**
 * A type of forum.
 *
 * @package    mod
 * @subpackage forum
 * @copyright  2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot.'/user/selector/lib.php');

/**
 * Abstract class used by forum subscriber selection controls
 */
abstract class mod_forum_subscriber_selector_base extends user_selector_base {

    /**
     * The id of the forum this selector is being used for
     * @var int
     */
    protected $forumid = null;
    /**
     * The context of the forum this selector is being used for
     * @var object
     */
    protected $context = null;
    /**
     * The id of the current group
     * @var int
     */
    protected $currentgroup = null;

    /**
     * Constructor method
     * @param string $name
     * @param array $options
     */
    public function __construct($name, $options) {
        $options['accesscontext'] = $options['context'];
        parent::__construct($name, $options);
        if (isset($options['context'])) {
            $this->context = $options['context'];
        }
        if (isset($options['currentgroup'])) {
            $this->currentgroup = $options['currentgroup'];
        }
        if (isset($options['forumid'])) {
            $this->forumid = $options['forumid'];
        }
    }

    /**
     * Returns an array of options to seralise and store for searches
     *
     * @return array
     */
    protected function get_options() {
        global $CFG;
        $options = parent::get_options();
        $options['file'] =  substr(__FILE__, strlen($CFG->dirroot.'/'));
        $options['context'] = $this->context;
        $options['currentgroup'] = $this->currentgroup;
        $options['forumid'] = $this->forumid;
        return $options;
    }

}
