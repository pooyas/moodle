<?php

/**
 * The library file for the file cache store.
 *
 * This file is part of the file cache store, it contains the API for interacting with an instance of the store.
 * This is used as a default cache store within the Cache API. It should never be deleted.
 *
 * @package    cachestore
 * @subpackage file
 * @copyright  2015 Pooya Saeedi
 * 
 */

require_once($CFG->dirroot.'/cache/forms.php');

/**
 * Form for adding a file instance.
 *
 */
class cachestore_file_addinstance_form extends cachestore_addinstance_form {

    /**
     * Adds the desired form elements.
     */
    protected function configuration_definition() {
        $form = $this->_form;

        $form->addElement('text', 'path', get_string('path', 'cachestore_file'));
        $form->setType('path', PARAM_SAFEPATH);
        $form->addHelpButton('path', 'path', 'cachestore_file');

        $form->addElement('checkbox', 'autocreate', get_string('autocreate', 'cachestore_file'));
        $form->setType('autocreate', PARAM_BOOL);
        $form->addHelpButton('autocreate', 'autocreate', 'cachestore_file');
        $form->disabledIf('autocreate', 'path', 'eq', '');

        $form->addElement('checkbox', 'singledirectory', get_string('singledirectory', 'cachestore_file'));
        $form->setType('singledirectory', PARAM_BOOL);
        $form->addHelpButton('singledirectory', 'singledirectory', 'cachestore_file');

        $form->addElement('checkbox', 'prescan', get_string('prescan', 'cachestore_file'));
        $form->setType('prescan', PARAM_BOOL);
        $form->addHelpButton('prescan', 'prescan', 'cachestore_file');
    }
}