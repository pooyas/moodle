<?php

/**
 * Settings for the HTML block
 *
 * @copyright 2012 Aaron Barnes
 * 
 * @package   block_html
 */

defined('LION_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configcheckbox('block_html_allowcssclasses', get_string('allowadditionalcssclasses', 'block_html'),
                       get_string('configallowadditionalcssclasses', 'block_html'), 0));
}


