<?php


/**
 * Drop down for question categories.
 *
 * Contains HTML class for a drop down element to select a question category.
 *
 * @package   core_form
 * @copyright 2007 Tim Hunt
 * 
 */

global $CFG;
require_once("$CFG->libdir/form/selectgroups.php");
require_once("$CFG->libdir/questionlib.php");

/**
 * Drop down for question categories.
 *
 * HTML class for a drop down element to select a question category.
 *
 * @package   core_form
 * @category  form
 * @copyright 2007 Tim Hunt
 * 
 */
class LionQuickForm_questioncategory extends LionQuickForm_selectgroups {
    /** @var array default options for question categories */
    var $_options = array('top'=>false, 'currentcat'=>0, 'nochildrenof' => -1);

    /**
     * Constructor
     *
     * @param string $elementName Select name attribute
     * @param mixed $elementLabel Label(s) for the select
     * @param array $options additional options. Recognised options are courseid, published and
     *              only_editable, corresponding to the arguments of question_category_options
     *              from lionlib.php.
     * @param mixed $attributes Either a typical HTML attribute string or an associative array
     */
    function LionQuickForm_questioncategory($elementName = null, $elementLabel = null, $options = null, $attributes = null) {
        LionQuickForm_selectgroups::LionQuickForm_selectgroups($elementName, $elementLabel, array(), $attributes);
        $this->_type = 'questioncategory';
        if (is_array($options)) {
            $this->_options = $options + $this->_options;
            $this->loadArrayOptGroups(
                        question_category_options($this->_options['contexts'], $this->_options['top'], $this->_options['currentcat'],
                                                false, $this->_options['nochildrenof']));
        }
    }

}
