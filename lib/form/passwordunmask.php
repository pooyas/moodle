<?php



/**
 * Password type form element with unmask option
 *
 * Contains HTML class for a password type element with unmask option
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

if (!defined('LION_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Lion page
}

global $CFG;
require_once($CFG->libdir.'/form/password.php');

/**
 * Password type form element with unmask option
 *
 * HTML class for a password type element with unmask option
 *
 * @category  form
 */
class LionQuickForm_passwordunmask extends LionQuickForm_password {
    /**
     * constructor
     *
     * @param string $elementName (optional) name of the password element
     * @param string $elementLabel (optional) label for password element
     * @param mixed $attributes (optional) Either a typical HTML attribute string
     *              or an associative array
     */
    function LionQuickForm_passwordunmask($elementName=null, $elementLabel=null, $attributes=null) {
        global $CFG;
        // no standard mform in lion should allow autocomplete of passwords
        if (empty($attributes)) {
            $attributes = array('autocomplete'=>'off');
        } else if (is_array($attributes)) {
            $attributes['autocomplete'] = 'off';
        } else {
            if (strpos($attributes, 'autocomplete') === false) {
                $attributes .= ' autocomplete="off" ';
            }
        }

        parent::LionQuickForm_password($elementName, $elementLabel, $attributes);
    }

    /**
     * Returns HTML for password form element.
     *
     * @return string
     */
    function toHtml() {
        global $PAGE;

        if ($this->_flagFrozen) {
            return $this->getFrozenHtml();
        } else {
            $unmask = get_string('unmaskpassword', 'form');
            //Pass id of the element, so that unmask checkbox can be attached.
            $attributes = array('formid' => $this->getAttribute('id'),
                'checkboxlabel' => $unmask,
                'checkboxname' => $this->getAttribute('name'));
            $PAGE->requires->yui_module('lion-form-passwordunmask', 'M.form.passwordunmask',
                    array($attributes));
            return $this->_getTabs() . '<input' . $this->_getAttrString($this->_attributes) . ' />';
        }
    }

}
