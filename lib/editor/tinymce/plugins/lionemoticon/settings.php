<?php

/**
 * Emoticon integration settings.
 *
 * @package   tinymce_lionemoticon
 * @copyright 2015 Pooya Saeedi 
 * 
 */

defined('LION_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configcheckbox('tinymce_lionemoticon/requireemoticon',
        get_string('requireemoticon', 'tinymce_lionemoticon'), get_string('requireemoticon_desc', 'tinymce_lionemoticon'), 1));
}
