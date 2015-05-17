<?php


/**
 * This file contains the forms to create and edit an instance of this module
 *
 * @package    mod
 * @subpackage assignment
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die('Direct access to this script is forbidden.');

require_once($CFG->dirroot.'/course/lionform_mod.php');

/**
 * Disabled assignment settings form.
 *
 */
class mod_assignment_mod_form extends lionform_mod {

    /**
     * Called to define this lion form
     *
     * @return void
     */
    public function definition() {
        print_error('assignmentdisabled', 'assignment');
    }


}
