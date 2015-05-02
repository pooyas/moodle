<?php


/**
 * Resets the emoticons mapping into the default value
 *
 * @package   core
 * @copyright 2010 David Mudrak <david@lion.com>
 * 
 */

require(dirname(dirname(__FILE__)) . '/config.php');
require_once($CFG->libdir.'/adminlib.php');

admin_externalpage_setup('resetemoticons');

$confirm = optional_param('confirm', false, PARAM_BOOL);

if (!$confirm or !confirm_sesskey()) {
    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('confirmation', 'admin'));
    echo $OUTPUT->confirm(get_string('emoticonsreset', 'admin'),
        new lion_url($PAGE->url, array('confirm' => 1)),
        new lion_url('/admin/settings.php', array('section' => 'htmlsettings')));
    echo $OUTPUT->footer();
    die();
}

$manager = get_emoticon_manager();
set_config('emoticons', $manager->encode_stored_config($manager->default_emoticons()));
redirect(new lion_url('/admin/settings.php', array('section' => 'htmlsettings')));
