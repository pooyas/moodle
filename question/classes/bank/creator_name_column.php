<?php


namespace core_question\bank;

/**
 * A column type for the name of the question creator.
 *
 * @copyright  2009 Tim Hunt
 * 
 */

class creator_name_column extends column_base {
    public function get_name() {
        return 'creatorname';
    }

    protected function get_title() {
        return get_string('createdby', 'question');
    }

    protected function display_content($question, $rowclasses) {
        if (!empty($question->creatorfirstname) && !empty($question->creatorlastname)) {
            $u = new \stdClass();
            $u = username_load_fields_from_object($u, $question, 'creator');
            echo fullname($u);
        }
    }

    public function get_extra_joins() {
        return array('uc' => 'LEFT JOIN {user} uc ON uc.id = q.createdby');
    }

    public function get_required_fields() {
        $allnames = get_all_user_name_fields();
        $requiredfields = array();
        foreach ($allnames as $allname) {
            $requiredfields[] = 'uc.' . $allname . ' AS creator' . $allname;
        }
        return $requiredfields;
    }

    public function is_sortable() {
        return array(
            'firstname' => array('field' => 'uc.firstname', 'title' => get_string('firstname')),
            'lastname' => array('field' => 'uc.lastname', 'title' => get_string('lastname')),
        );
    }
}
