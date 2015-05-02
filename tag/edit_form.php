<?php


/**
 * @package    core_tag
 * @category   tag
 * @copyright  2007 Luiz Cruz <luiz.laydner@gmail.com>
 * 
 */

if (!defined('LION_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Lion page
}

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * Defines the form for editing tags
 *
 * @package    core_tag
 * @category   tag
 * @copyright  2007 Luiz Cruz <luiz.laydner@gmail.com>
 * 
 */
class tag_edit_form extends lionform {

    /**
     * Overrides the abstract lionform::definition method for defining what the form that is to be
     * presented to the user.
     */
    function definition () {

        $mform =& $this->_form;

        $mform->addElement('header', 'tag', get_string('description','tag'));

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $systemcontext   = context_system::instance();

        if (has_capability('lion/tag:manage', $systemcontext)) {
            $mform->addElement('text', 'rawname', get_string('name', 'tag'),
                    'maxlength="'.TAG_MAX_LENGTH.'" size="'.TAG_MAX_LENGTH.'"');
            $mform->setType('rawname', PARAM_NOTAGS);
        }

        $mform->addElement('editor', 'description_editor', get_string('description', 'tag'), null, $this->_customdata['editoroptions']);

        if (has_capability('lion/tag:manage', $systemcontext)) {
           $mform->addElement('checkbox', 'tagtype', get_string('officialtag', 'tag'));
        }

        $mform->addElement('html', '<br/><div id="relatedtags-autocomplete-container">');
        $mform->addElement('textarea', 'relatedtags', get_string('relatedtags','tag'), 'cols="50" rows="3"');
        $mform->setType('relatedtags', PARAM_TAGLIST);
        $mform->addElement('html', '<div id="relatedtags-autocomplete"></div>');
        $mform->addElement('html', '</div>');

        $this->add_action_buttons(false, get_string('updatetag', 'tag'));

    }

}
