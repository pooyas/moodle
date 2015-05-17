<?php



/**
 * @package    mod
 * @subpackage feedback
 * @copyright  2015 Pooya Saeedi
*/

defined('LION_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $options = array(0=>get_string('no'), 1=>get_string('yes'));
    $str = get_string('configallowfullanonymous', 'feedback');
    $settings->add(new admin_setting_configselect('feedback_allowfullanonymous',
                                    get_string('allowfullanonymous', 'feedback'),
                                    $str, 0, $options));
}
