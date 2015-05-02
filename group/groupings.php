<?php


/**
 * Allows a creator to edit groupings
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package core_group
 */

require_once '../config.php';
require_once $CFG->dirroot.'/group/lib.php';

$courseid = required_param('id', PARAM_INT);

$PAGE->set_url('/group/groupings.php', array('id'=>$courseid));

if (!$course = $DB->get_record('course', array('id'=>$courseid))) {
    print_error('nocourseid');
}

require_login($course);
$context = context_course::instance($course->id);
require_capability('lion/course:managegroups', $context);

$strgrouping     = get_string('grouping', 'group');
$strgroups       = get_string('groups');
$strname         = get_string('name');
$strdelete       = get_string('delete');
$stredit         = get_string('edit');
$srtnewgrouping  = get_string('creategrouping', 'group');
$strgroups       = get_string('groups');
$strgroupings    = get_string('groupings', 'group');
$struses         = get_string('activities');
$strparticipants = get_string('participants');
$strmanagegrping = get_string('showgroupsingrouping', 'group');

navigation_node::override_active_url(new lion_url('/group/index.php', array('id'=>$courseid)));
$PAGE->navbar->add($strgroupings);

/// Print header
$PAGE->set_title($strgroupings);
$PAGE->set_heading($course->fullname);
$PAGE->set_pagelayout('standard');
echo $OUTPUT->header();

// Add tabs
$currenttab = 'groupings';
require('tabs.php');

echo $OUTPUT->heading($strgroupings);

$data = array();
if ($groupings = $DB->get_records('groupings', array('courseid'=>$course->id), 'name')) {
    $canchangeidnumber = has_capability('lion/course:changeidnumber', $context);
    foreach ($groupings as $gid => $grouping) {
        $groupings[$gid]->formattedname = format_string($grouping->name, true, array('context' => $context));
    }
    core_collator::asort_objects_by_property($groupings, 'formattedname');
    foreach($groupings as $grouping) {
        $line = array();
        $line[0] = $grouping->formattedname;

        if ($groups = groups_get_all_groups($courseid, 0, $grouping->id)) {
            $groupnames = array();
            foreach ($groups as $group) {
                $groupnames[] = format_string($group->name);
            }
            $line[1] = implode(', ', $groupnames);
        } else {
            $line[1] = get_string('none');
        }
        $line[2] = $DB->count_records('course_modules', array('course'=>$course->id, 'groupingid'=>$grouping->id));

        $url = new lion_url('/group/grouping.php', array('id' => $grouping->id));
        $buttons  = html_writer::link($url, $OUTPUT->pix_icon('t/edit', $stredit, 'core',
                array('class' => 'iconsmall')), array('title' => $stredit));
        if (empty($grouping->idnumber) || $canchangeidnumber) {
            // It's only possible to delete groups without an idnumber unless the user has the changeidnumber capability.
            $url = new lion_url('/group/grouping.php', array('id' => $grouping->id, 'delete' => 1));
            $buttons .= html_writer::link($url, $OUTPUT->pix_icon('t/delete', $strdelete, 'core',
                    array('class' => 'iconsmall')), array('title' => $strdelete));
        } else {
            $buttons .= $OUTPUT->spacer();
        }
        $url = new lion_url('/group/assign.php', array('id' => $grouping->id));
        $buttons .= html_writer::link($url, $OUTPUT->pix_icon('t/groups', $strmanagegrping, 'core',
                array('class' => 'iconsmall')), array('title' => $strmanagegrping));

        $line[3] = $buttons;
        $data[] = $line;
    }
}
$table = new html_table();
$table->head  = array($strgrouping, $strgroups, $struses, $stredit);
$table->size  = array('30%', '50%', '10%', '10%');
$table->align = array('left', 'left', 'center', 'center');
$table->width = '90%';
$table->data  = $data;
echo html_writer::table($table);

echo $OUTPUT->container_start('buttons');
echo $OUTPUT->single_button(new lion_url('grouping.php', array('courseid'=>$courseid)), $srtnewgrouping);
echo $OUTPUT->container_end();

echo $OUTPUT->footer();
