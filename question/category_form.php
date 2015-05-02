<?php

/**
 * Defines the form for editing question categories.
 *
 * @package    lioncore
 * @subpackage questionbank
 * @copyright  2007 Jamie Pratt me@jamiep.org
 * 
 */


defined('LION_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');


/**
 * Form for editing qusetions categories (name, description, etc.)
 *
 * @copyright  2007 Jamie Pratt me@jamiep.org
 * 
 */
class question_category_edit_form extends lionform {

    protected function definition() {
        global $CFG, $DB;
        $mform    = $this->_form;

        $contexts   = $this->_customdata['contexts'];
        $currentcat   = $this->_customdata['currentcat'];

        $mform->addElement('header', 'categoryheader', get_string('addcategory', 'question'));

        $questioncategoryel = $mform->addElement('questioncategory', 'parent', get_string('parentcategory', 'question'),
                    array('contexts'=>$contexts, 'top'=>true, 'currentcat'=>$currentcat, 'nochildrenof'=>$currentcat));
        $mform->setType('parent', PARAM_SEQUENCE);
        if (question_is_only_toplevel_category_in_context($currentcat)) {
            $mform->hardFreeze('parent');
        }
        $mform->addHelpButton('parent', 'parentcategory', 'question');

        $mform->addElement('text', 'name', get_string('name'),'maxlength="254" size="50"');
        $mform->setDefault('name', '');
        $mform->addRule('name', get_string('categorynamecantbeblank', 'question'), 'required', null, 'client');
        $mform->setType('name', PARAM_TEXT);

        $mform->addElement('editor', 'info', get_string('categoryinfo', 'question'),
                array('rows' => 10), array('noclean' => 1));
        $mform->setDefault('info', '');
        $mform->setType('info', PARAM_RAW);

        $this->add_action_buttons(false, get_string('addcategory', 'question'));

        $mform->addElement('hidden', 'id', 0);
        $mform->setType('id', PARAM_INT);
    }

    public function set_data($current) {
        if (is_object($current)) {
            $current = (array) $current;
        }
        if (!empty($current['info'])) {
            $current['info'] = array('text' => $current['info'],
                    'infoformat' => $current['infoformat']);
        } else {
            $current['info'] = array('text' => '', 'infoformat' => FORMAT_HTML);
        }
        parent::set_data($current);
    }
}
