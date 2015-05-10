<?php

/**
 * This file defines the admin settings for this plugin
 *
 * @package   assignsubmission
 * @subpackage onlinetext
 * @copyright 2015 Pooya Saeedi 
 * 
 */

$settings->add(new admin_setting_configcheckbox('assignsubmission_onlinetext/default',
                   new lang_string('default', 'assignsubmission_onlinetext'),
                   new lang_string('default_help', 'assignsubmission_onlinetext'), 0));

