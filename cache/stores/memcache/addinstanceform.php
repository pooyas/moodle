<?php

/**
 * The library file for the memcache cache store.
 *
 * This file is part of the memcache cache store, it contains the API for interacting with an instance of the store.
 *
 * @package    cachestore
 * @subpackage memcache
 * @copyright  2015 Pooya Saeedi
s * 
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot.'/cache/forms.php');

/**
 * Form for adding a memcache instance.
 *
 */
class cachestore_memcache_addinstance_form extends cachestore_addinstance_form {

    /**
     * Add the desired form elements.
     */
    protected function configuration_definition() {
        $form = $this->_form;
        $form->addElement('textarea', 'servers', get_string('servers', 'cachestore_memcache'), array('cols' => 75, 'rows' => 5));
        $form->addHelpButton('servers', 'servers', 'cachestore_memcache');
        $form->addRule('servers', get_string('required'), 'required');
        $form->setType('servers', PARAM_RAW);

        $form->addElement('text', 'prefix', get_string('prefix', 'cachestore_memcache'),
                array('maxlength' => 5, 'size' => 5));
        $form->addHelpButton('prefix', 'prefix', 'cachestore_memcache');
        $form->setType('prefix', PARAM_TEXT); // We set to text but we have a rule to limit to alphanumext.
        $form->setDefault('prefix', 'mdl_');
        $form->addRule('prefix', get_string('prefixinvalid', 'cachestore_memcache'), 'regex', '#^[a-zA-Z0-9\-_]+$#');

        $form->addElement('header', 'clusteredheader', get_string('clustered', 'cachestore_memcache'));

        $form->addElement('checkbox', 'clustered', get_string('clustered', 'cachestore_memcache'));
        $form->setDefault('checkbox', false);
        $form->addHelpButton('clustered', 'clustered', 'cachestore_memcache');

        $form->addElement('textarea', 'setservers', get_string('setservers', 'cachestore_memcache'),
                array('cols' => 75, 'rows' => 5));
        $form->addHelpButton('setservers', 'setservers', 'cachestore_memcache');
        $form->disabledIf('setservers', 'clustered');
        $form->setType('setservers', PARAM_RAW);
    }

    /**
     * Perform minimal validation on the settings form.
     *
     * @param array $data
     * @param array $files
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        if (isset($data['clustered']) && ($data['clustered'] == 1)) {
            // Set servers is required with in cluster mode.
            if (!isset($data['setservers'])) {
                $errors['setservers'] = get_string('required');
            } else {
                $trimmed = trim($data['setservers']);
                if (empty($trimmed)) {
                    $errors['setservers'] = get_string('required');
                }
            }

            $validservers = false;
            if (isset($data['servers'])) {
                $servers = trim($data['servers']);
                $servers = explode("\n", $servers);
                if (count($servers) === 1) {
                    $validservers = true;
                }
            }

            if (!$validservers) {
                $errors['servers'] = get_string('serversclusterinvalid', 'cachestore_memcache');
            }
        }

        return $errors;
    }
}