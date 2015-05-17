<?php


/**
 * Defines the Lion forum used to add random questions to the quiz.
 *
 * @package    mod
 * @subpackage quiz
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');


/**
 * The add random questions form.
 *
 */
class quiz_add_random_form extends lionform {

    protected function definition() {
        global $CFG, $DB;
        $mform =& $this->_form;
        $mform->setDisableShortforms();

        $contexts = $this->_customdata['contexts'];
        $usablecontexts = $contexts->having_cap('lion/question:useall');

        // Random from existing category section.
        $mform->addElement('header', 'categoryheader',
                get_string('randomfromexistingcategory', 'quiz'));

        $mform->addElement('questioncategory', 'category', get_string('category'),
                array('contexts' => $usablecontexts, 'top' => false));
        $mform->setDefault('category', $this->_customdata['cat']);

        $mform->addElement('checkbox', 'includesubcategories', '', get_string('recurse', 'quiz'));

        $mform->addElement('select', 'numbertoadd', get_string('randomnumber', 'quiz'),
                $this->get_number_of_questions_to_add_choices());

        $mform->addElement('submit', 'existingcategory', get_string('addrandomquestion', 'quiz'));

        // Random from a new category section.
        $mform->addElement('header', 'categoryheader',
                get_string('randomquestionusinganewcategory', 'quiz'));

        $mform->addElement('text', 'name', get_string('name'), 'maxlength="254" size="50"');
        $mform->setType('name', PARAM_TEXT);

        $mform->addElement('questioncategory', 'parent', get_string('parentcategory', 'question'),
                array('contexts' => $usablecontexts, 'top' => true));
        $mform->addHelpButton('parent', 'parentcategory', 'question');

        $mform->addElement('submit', 'newcategory',
                get_string('createcategoryandaddrandomquestion', 'quiz'));

        // Cancel button.
        $mform->addElement('cancel');
        $mform->closeHeaderBefore('cancel');

        $mform->addElement('hidden', 'addonpage', 0, 'id="rform_qpage"');
        $mform->setType('addonpage', PARAM_SEQUENCE);
        $mform->addElement('hidden', 'cmid', 0);
        $mform->setType('cmid', PARAM_INT);
        $mform->addElement('hidden', 'returnurl', 0);
        $mform->setType('returnurl', PARAM_LOCALURL);
    }

    public function validation($fromform, $files) {
        $errors = parent::validation($fromform, $files);

        if (!empty($fromform['newcategory']) && trim($fromform['name']) == '') {
            $errors['name'] = get_string('categorynamecantbeblank', 'question');
        }

        return $errors;
    }

    /**
     * Return an arbitrary array for the dropdown menu
     * @return array of integers array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100)
     */
    private function get_number_of_questions_to_add_choices() {
        $maxrand = 100;
        $randomcount = array();
        for ($i = 1; $i <= min(10, $maxrand); $i++) {
            $randomcount[$i] = $i;
        }
        for ($i = 20; $i <= min(100, $maxrand); $i += 10) {
            $randomcount[$i] = $i;
        }
        return $randomcount;
    }
}
