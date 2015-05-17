<?php


/**
 * Form for editing tag block instances.
 *
 * @package    blocks
 * @subpackage tags
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Form for editing tag block instances.
 *
 */
class block_tags_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('configtitle', 'block_tags'));
        $mform->setType('config_title', PARAM_TEXT);
        $mform->setDefault('config_title', get_string('pluginname', 'block_tags'));

        $numberoftags = array();
        for ($i = 1; $i <= 200; $i++) {
            $numberoftags[$i] = $i;
        }
        $mform->addElement('select', 'config_numberoftags', get_string('numberoftags', 'blog'), $numberoftags);
        $mform->setDefault('config_numberoftags', 80);

        $defaults = array('default'=>'default', 'official'=>'official', ''=>'both');
        $mform->addElement('select', 'config_tagtype', get_string('defaultdisplay', 'block_tags'), $defaults);
        $mform->setDefault('config_tagtype', '');
    }
}
