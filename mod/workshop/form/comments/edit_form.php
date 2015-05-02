<?php


/**
 * This file defines an mform to edit comments grading strategy forms.
 *
 * @package    workshopform_comments
 * @copyright  2009 David Mudrak <david.mudrak@gmail.com>
 * 
 */

defined('LION_INTERNAL') || die();

require_once(dirname(dirname(dirname(__FILE__))).'/lib.php');   // module library
require_once(dirname(dirname(__FILE__)).'/edit_form.php');    // parent class definition

/**
 * Class for editing comments grading strategy forms.
 *
 * @uses lionform
 */
class workshop_edit_comments_strategy_form extends workshop_edit_strategy_form {

    /**
     * Define the elements to be displayed at the form
     *
     * Called by the parent::definition()
     *
     * @return void
     */
    protected function definition_inner(&$mform) {

        $norepeats          = $this->_customdata['norepeats'];          // number of dimensions to display
        $descriptionopts    = $this->_customdata['descriptionopts'];    // wysiwyg fields options
        $current            = $this->_customdata['current'];            // current data to be set

        $mform->addElement('hidden', 'norepeats', $norepeats);
        $mform->setType('norepeats', PARAM_INT);
        // value not to be overridden by submitted value
        $mform->setConstants(array('norepeats' => $norepeats));

        for ($i = 0; $i < $norepeats; $i++) {
            $mform->addElement('header', 'dimension'.$i, get_string('dimensionnumber', 'workshopform_comments', $i+1));
            $mform->addElement('hidden', 'dimensionid__idx_'.$i);
            $mform->setType('dimensionid__idx_'.$i, PARAM_INT);
            $mform->addElement('editor', 'description__idx_'.$i.'_editor',
                                get_string('dimensiondescription', 'workshopform_comments'), '', $descriptionopts);
        }

        $mform->registerNoSubmitButton('noadddims');
        $mform->addElement('submit', 'noadddims', get_string('addmoredimensions', 'workshopform_comments',
                workshop_comments_strategy::ADDDIMS));
        $mform->closeHeaderBefore('noadddims');
        $this->set_data($current);
    }
}
