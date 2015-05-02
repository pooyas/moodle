<?php


/**
 * This file defines an mform to assess a submission by numerrors grading strategy
 *
 * @package    workshopform_numerrors
 * @copyright  2009 David Mudrak <david.mudrak@gmail.com>
 * 
 */

defined('LION_INTERNAL') || die();

require_once(dirname(dirname(__FILE__)).'/assessment_form.php');    // parent class definition

/**
 * Class representing a form for assessing submissions by numerrors grading strategy
 *
 * @uses lionform
 */
class workshop_numerrors_assessment_form extends workshop_assessment_form {

    /**
     * Define the elements to be displayed at the form
     *
     * Called by the parent::definition()
     *
     * @return void
     */
    protected function definition_inner(&$mform) {
        $fields     = $this->_customdata['fields'];
        $current    = $this->_customdata['current'];
        $nodims     = $this->_customdata['nodims'];     // number of assessment dimensions

        $mform->addElement('hidden', 'nodims', $nodims);
        $mform->setType('nodims', PARAM_INT);

        for ($i = 0; $i < $nodims; $i++) {
            // dimension header
            $dimtitle = get_string('dimensionnumber', 'workshopform_numerrors', $i+1);
            $mform->addElement('header', "dimensionhdr__idx_$i", $dimtitle);

            // dimension id
            $mform->addElement('hidden', 'dimensionid__idx_'.$i, $fields->{'dimensionid__idx_'.$i});
            $mform->setType('dimensionid__idx_'.$i, PARAM_INT);

            // grade id
            $mform->addElement('hidden', 'gradeid__idx_'.$i);   // value set by set_data() later
            $mform->setType('gradeid__idx_'.$i, PARAM_INT);

            // dimension description
            $desc = '<div id="id_dim_'.$fields->{'dimensionid__idx_'.$i}.'_desc" class="fitem description numerrors">'."\n";
            $desc .= format_text($fields->{'description__idx_'.$i}, $fields->{'description__idx_'.$i.'format'});
            $desc .= "\n</div>";
            $mform->addElement('html', $desc);

            // evaluation of the assertion
            $label = get_string('dimensiongrade', 'workshopform_numerrors');
            $mform->addGroup(array(
                $mform->createElement('radio', 'grade__idx_' . $i, '', $fields->{'grade0__idx_'.$i}, -1),
                $mform->createElement('radio', 'grade__idx_' . $i, '', $fields->{'grade1__idx_'.$i}, 1),
            ), 'group_grade__idx_' . $i, get_string('yourassessment', 'workshop'), '<br />', false);
            $mform->addRule('group_grade__idx_' . $i, get_string('required'), 'required');

            // comment
            $label = get_string('dimensioncomment', 'workshopform_numerrors');
            $mform->addElement('textarea', 'peercomment__idx_' . $i, $label, array('cols' => 60, 'rows' => 5));
        }
        $this->set_data($current);
    }
}
