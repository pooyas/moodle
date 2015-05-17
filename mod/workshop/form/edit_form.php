<?php


/**
 * This file defines a base class for all grading strategy editing forms.
 *
 * @package    mod
 * @subpackage workshop
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

require_once($CFG->libdir . '/formslib.php'); // parent class definition

/**
 * Base class for editing all the strategy grading forms.
 *
 * This defines the common fields that all strategy grading forms need.
 * Strategies should define their own  class that inherits from this one, and
 * implements the definition_inner() method.
 *
 * @uses lionform
 */
class workshop_edit_strategy_form extends lionform {

    /** strategy logic instance that this class is editor of */
    protected $strategy;

    /**
     * Add the fields that are common for all grading strategies.
     *
     * If the strategy does not support all these fields, then you can override
     * this method and remove the ones you don't want with
     * $mform->removeElement().
     * Stretegy subclassess should define their own fields in definition_inner()
     *
     * @return void
     */
    public function definition() {
        global $CFG;

        $mform = $this->_form;
        $this->workshop = $this->_customdata['workshop'];
        $this->strategy = $this->_customdata['strategy'];

        $mform->addElement('hidden', 'workshopid', $this->workshop->id);        // workshopid
        $mform->setType('workshopid', PARAM_INT);

        $mform->addElement('hidden', 'strategy', $this->workshop->strategy);    // strategy name
        $mform->setType('strategy', PARAM_PLUGIN);

        $this->definition_inner($mform);

        // todo - tags support
        //if (!empty($CFG->usetags)) {
        //    $mform->addElement('header', 'tagsheader', get_string('tags'));
        //    $mform->addElement('tags', 'tags', get_string('tags'));
        //}

        $buttonarray = array();
        $buttonarray[] = $mform->createElement('submit', 'saveandcontinue', get_string('saveandcontinue', 'workshop'));
        $buttonarray[] = $mform->createElement('submit', 'saveandpreview', get_string('saveandpreview', 'workshop'));
        $buttonarray[] = $mform->createElement('submit', 'saveandclose', get_string('saveandclose', 'workshop'));
        $buttonarray[] = $mform->createElement('cancel');
        $mform->addGroup($buttonarray, 'buttonar', '', array(' '), false);
        $mform->closeHeaderBefore('buttonar');
    }

    /**
     * Add any strategy specific form fields.
     *
     * @param stdClass $mform the form being built.
     */
    protected function definition_inner(&$mform) {
        // By default, do nothing.
    }

}
