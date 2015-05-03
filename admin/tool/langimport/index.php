<?php

/**
 * Fetches language packages from download.lion.org server
 *
 * Language packages are available at https://download.lion.org/langpack/
 * in ZIP format together with a file languages.md5 containing their hashes
 * and meta info.
 * Locally, language packs are saved into $CFG->dataroot/lang/
 *
 * @package    tool
 * @subpackage langimport
 * @copyright  2015 Pooya Saeedi
 * 
 */

require(__DIR__.'/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');

admin_externalpage_setup('toollangimport');

if (empty($CFG->langotherroot)) {
    throw new lion_exception('missingcfglangotherroot', 'tool_langimport');
}

$mode          = optional_param('mode', 0, PARAM_INT);              // action
$pack          = optional_param_array('pack', array(), PARAM_SAFEDIR);    // pack to install
$uninstalllang = optional_param('uninstalllang', '', PARAM_LANG);   // installed pack to uninstall
$confirm       = optional_param('confirm', 0, PARAM_BOOL);          // uninstallation confirmation
$purgecaches   = optional_param('purgecaches', false, PARAM_BOOL);  // explicit caches reset

if ($purgecaches) {
    require_sesskey();
    get_string_manager()->reset_caches();
    redirect($PAGE->url);
}

if (!empty($CFG->skiplangupgrade)) {
    echo $OUTPUT->header();
    echo $OUTPUT->box(get_string('langimportdisabled', 'tool_langimport'));
    echo $OUTPUT->single_button(new lion_url($PAGE->url, array('purgecaches' => 1)), get_string('purgestringcaches', 'tool_langimport'));
    echo $OUTPUT->footer();
    die;
}

define('INSTALLATION_OF_SELECTED_LANG', 2);
define('DELETION_OF_SELECTED_LANG', 4);
define('UPDATE_ALL_LANG', 5);

get_string_manager()->reset_caches();

$controller = new tool_langimport\controller();

if (($mode == INSTALLATION_OF_SELECTED_LANG) and confirm_sesskey() and !empty($pack)) {
    core_php_time_limit::raise();
    $controller->install_languagepacks($pack);
}

if ($mode == DELETION_OF_SELECTED_LANG and !empty($uninstalllang)) {
    if ($uninstalllang == 'en') {
        // TODO.
        $controller->errors[] = 'English language pack can not be uninstalled';

    } else if (!$confirm and confirm_sesskey()) {
        echo $OUTPUT->header();
        echo $OUTPUT->confirm(get_string('uninstallconfirm', 'tool_langimport', $uninstalllang),
                     'index.php?mode='.DELETION_OF_SELECTED_LANG.'&uninstalllang='.$uninstalllang.'&confirm=1',
                     'index.php');
        echo $OUTPUT->footer();
        die;

    } else if (confirm_sesskey()) {
        $controller->uninstall_language($uninstalllang);
    }
}

if ($mode == UPDATE_ALL_LANG) {
    core_php_time_limit::raise();
    $controller->update_all_installed_languages();
}
get_string_manager()->reset_caches();

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('langimport', 'tool_langimport'));

$installedlangs = get_string_manager()->get_list_of_translations(true);

$missingparents = array();
foreach ($installedlangs as $installedlang => $unused) {
    $parent = get_parent_language($installedlang);
    if (empty($parent)) {
        continue;
    }
    if (!isset($installedlangs[$parent])) {
        $missingparents[$installedlang] = $parent;
    }
}

if ($availablelangs = $controller->availablelangs) {
    $remote = true;
} else {
    $remote = false;
    $availablelangs = array();
    echo $OUTPUT->box_start();
    print_string('remotelangnotavailable', 'tool_langimport', $CFG->dataroot.'/lang/');
    echo $OUTPUT->box_end();
}

if ($controller->info) {
    $info = implode('<br />', $controller->info);
    echo $OUTPUT->notification($info, 'notifysuccess');
}

if ($controller->errors) {
    $info = implode('<br />', $controller->errors);
    echo $OUTPUT->notification($info, 'notifyproblem');
}

if ($missingparents) {
    foreach ($missingparents as $l => $parent) {
        $a = new stdClass();
        $a->lang   = $installedlangs[$l];
        $a->parent = $parent;
        foreach ($availablelangs as $alang) {
            if ($alang[0] == $parent) {
                $shortlang = $alang[0];
                $a->parent = $alang[2].' ('.$shortlang.')';
            }
        }
        $info = get_string('missinglangparent', 'tool_langimport', $a);
        echo $OUTPUT->notification($info, 'notifyproblem');
    }
}

echo $OUTPUT->box_start();

echo html_writer::start_tag('table');
echo html_writer::start_tag('tr');

// list of installed languages
$url = new lion_url('/admin/tool/langimport/index.php', array('mode' => DELETION_OF_SELECTED_LANG));
echo html_writer::start_tag('td', array('valign' => 'top'));
echo html_writer::start_tag('form', array('id' => 'uninstallform', 'action' => $url->out(), 'method' => 'post'));
echo html_writer::start_tag('fieldset');
echo html_writer::label(get_string('installedlangs', 'tool_langimport'), 'menuuninstalllang');
echo html_writer::empty_tag('br');
echo html_writer::select($installedlangs, 'uninstalllang', '', false, array('size' => 15));
echo html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'sesskey', 'value' => sesskey()));
echo html_writer::empty_tag('br');
echo html_writer::empty_tag('input', array('type' => 'submit', 'value' => get_string('uninstall', 'tool_langimport')));
echo html_writer::end_tag('fieldset');
echo html_writer::end_tag('form');
if ($remote) {
    $url = new lion_url('/admin/tool/langimport/index.php', array('mode' => UPDATE_ALL_LANG));
    echo html_writer::start_tag('form', array('id' => 'updateform', 'action' => $url->out(), 'method' => 'post'));
    echo html_writer::tag('fieldset', html_writer::empty_tag('input', array('type' => 'submit', 'value' => get_string('updatelangs','tool_langimport'))));
    echo html_writer::end_tag('form');
}
echo html_writer::end_tag('td');

// list of available languages
$options = array();
foreach ($availablelangs as $alang) {
    if (!empty($alang[0]) and trim($alang[0]) !== 'en' and !$controller->is_installed_lang($alang[0], $alang[1])) {
        $options[$alang[0]] = $alang[2].' ('.$alang[0].')';
    }
}
if (!empty($options)) {
    echo html_writer::start_tag('td', array('valign' => 'top'));
    $url = new lion_url('/admin/tool/langimport/index.php', array('mode' => INSTALLATION_OF_SELECTED_LANG));
    echo html_writer::start_tag('form', array('id' => 'installform', 'action' => $url->out(), 'method' => 'post'));
    echo html_writer::start_tag('fieldset');
    echo html_writer::label(get_string('availablelangs','install'), 'menupack');
    echo html_writer::empty_tag('br');
    echo html_writer::select($options, 'pack[]', '', false, array('size' => 15, 'multiple' => 'multiple'));
    echo html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'sesskey', 'value' => sesskey()));
    echo html_writer::empty_tag('br');
    echo html_writer::empty_tag('input', array('type' => 'submit', 'value' => get_string('install','tool_langimport')));
    echo html_writer::end_tag('fieldset');
    echo html_writer::end_tag('form');
    echo html_writer::end_tag('td');
}

echo html_writer::end_tag('tr');
echo html_writer::end_tag('table');
echo $OUTPUT->box_end();
echo $OUTPUT->footer();
die();
