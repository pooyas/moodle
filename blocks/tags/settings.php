<?php

/**
 * Settings for the tags block.
 *
 * @package    block
 * @subpackage tags
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configcheckbox('block_tags_showcoursetags', get_string('showcoursetags', 'block_tags'),
                       get_string('showcoursetagsdef', 'block_tags'), 0));
}
