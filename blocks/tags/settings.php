<?php

/**
 * Settings for the tags block.
 *
 * @package   block_tags
 * @copyright 1999 onwards Martin Dougiamas  {@link http://lion.com}
 * 
 */

defined('LION_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configcheckbox('block_tags_showcoursetags', get_string('showcoursetags', 'block_tags'),
                       get_string('showcoursetagsdef', 'block_tags'), 0));
}
