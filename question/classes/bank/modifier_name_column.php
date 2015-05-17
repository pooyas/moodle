<?php




/**
 * @package    question
 * @subpackage classes
 * @copyright  2015 Pooya Saeedi
*/

namespace core_question\bank;

/**
 * A column type for the name of the question last modifier.
 *
 */
class modifier_name_column extends column_base {
    public function get_name() {
        return 'modifiername';
    }

    protected function get_title() {
        return get_string('lastmodifiedby', 'question');
    }

    protected function display_content($question, $rowclasses) {
        if (!empty($question->modifierfirstname) && !empty($question->modifierlastname)) {
            $u = new \stdClass();
            $u = username_load_fields_from_object($u, $question, 'modifier');
            echo fullname($u);
        }
    }

    public function get_extra_joins() {
        return array('um' => 'LEFT JOIN {user} um ON um.id = q.modifiedby');
    }

    public function get_required_fields() {
        $allnames = get_all_user_name_fields();
        $requiredfields = array();
        foreach ($allnames as $allname) {
            $requiredfields[] = 'um.' . $allname . ' AS modifier' . $allname;
        }
        return $requiredfields;
    }

    public function is_sortable() {
        return array(
            'firstname' => array('field' => 'um.firstname', 'title' => get_string('firstname')),
            'lastname' => array('field' => 'um.lastname', 'title' => get_string('lastname')),
        );
    }
}
