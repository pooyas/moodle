<?php

/**
 * Base lib class for singleview functionality.
 *
 * @package    gradereport
 * @subpackage singleview
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

require_once($CFG->dirroot . '/grade/report/lib.php');

/**
 * This class is the main class that must be implemented by a grade report plugin.
 *
 */
class gradereport_singleview extends grade_report {

    /**
     * Return the list of valid screens, used to validate the input.
     *
     * @return array List of screens.
     */
    public static function valid_screens() {
        // This is a list of all the known classes representing a screen in this plugin.
        return array('user', 'select', 'grade');
    }

    /**
     * Process data from a form submission. Delegated to the current screen.
     *
     * @param array $data The data from the form
     * @return array List of warnings
     */
    public function process_data($data) {
        if (has_capability('lion/grade:manage', $this->context)) {
            return $this->screen->process($data);
        }
    }

    /**
     * Unused - abstract function declared in the parent class.
     *
     * @param string $target
     * @param string $action
     */
    public function process_action($target, $action) {
    }

    /**
     * Constructor for this report. Creates the appropriate screen class based on itemtype.
     *
     * @param int $courseid The course id.
     * @param object $gpr grade plugin return tracking object
     * @param context_course $context
     * @param string $itemtype Should be user, select or grade
     * @param int $itemid The id of the user or grade item
     * @param string $unused Used to be group id but that was removed and this is now unused.
     */
    public function __construct($courseid, $gpr, $context, $itemtype, $itemid, $unused = null) {
        parent::__construct($courseid, $gpr, $context);

        $base = '/grade/report/singleview/index.php';

        $idparams = array('id' => $courseid);

        $this->baseurl = new lion_url($base, $idparams);

        $this->pbarurl = new lion_url($base, $idparams + array(
                'item' => $itemtype,
                'itemid' => $itemid
            ));

        //  The setup_group method is used to validate group mode and permissions and define the currentgroup value.
        $this->setup_groups();

        $screenclass = "\\gradereport_singleview\\local\\screen\\${itemtype}";

        $this->screen = new $screenclass($courseid, $itemid, $this->currentgroup);

        // Load custom or predifined js.
        $this->screen->js();
    }

    /**
     * Build the html for the screen.
     * @return string HTML to display
     */
    public function output() {
        global $OUTPUT;
        return $OUTPUT->container($this->screen->html(), 'reporttable');
    }
}

