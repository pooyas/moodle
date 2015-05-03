<?php

/**
 * Page to handle actions associated with badges management.
 *
 * @package    core
 * @subpackage badges
 * @copyright  2015 Pooya Saeedi
 * 
 * @author     Yuliya Bozhko <yuliya.bozhko@totaralms.com>
 */

require_once(dirname(dirname(__FILE__)) . '/config.php');
require_once($CFG->libdir . '/badgeslib.php');

$badgeid = required_param('id', PARAM_INT);
$copy = optional_param('copy', 0, PARAM_BOOL);
$activate = optional_param('activate', 0, PARAM_BOOL);
$deactivate = optional_param('lock', 0, PARAM_BOOL);
$confirm   = optional_param('confirm', 0, PARAM_BOOL);
$return = optional_param('return', 0, PARAM_LOCALURL);

require_login();

$badge = new badge($badgeid);
$context = $badge->get_context();
$navurl = new lion_url('/badges/index.php', array('type' => $badge->type));

if ($badge->type == BADGE_TYPE_COURSE) {
    require_login($badge->courseid);
    $navurl = new lion_url('/badges/index.php', array('type' => $badge->type, 'id' => $badge->courseid));
    $PAGE->set_pagelayout('standard');
    navigation_node::override_active_url($navurl);
} else {
    $PAGE->set_pagelayout('admin');
    navigation_node::override_active_url($navurl, true);
}

$PAGE->set_context($context);
$PAGE->set_url('/badges/action.php', array('id' => $badge->id));

if ($return !== 0) {
    $returnurl = new lion_url($return);
} else {
    $returnurl = new lion_url('/badges/overview.php', array('id' => $badge->id));
}
$returnurl->remove_params('awards');

if ($copy) {
    require_sesskey();
    require_capability('lion/badges:createbadge', $context);

    $cloneid = $badge->make_clone();
    // If a user can edit badge details, they will be redirected to the edit page.
    if (has_capability('lion/badges:configuredetails', $context)) {
        redirect(new lion_url('/badges/edit.php', array('id' => $cloneid, 'action' => 'details')));
    }
    redirect(new lion_url('/badges/overview.php', array('id' => $cloneid)));
}

if ($activate) {
    require_capability('lion/badges:configurecriteria', $context);

    $PAGE->url->param('activate', 1);
    $status = ($badge->status == BADGE_STATUS_INACTIVE) ? BADGE_STATUS_ACTIVE : BADGE_STATUS_ACTIVE_LOCKED;
    if ($confirm == 1) {
        require_sesskey();
        $badge->set_status($status);
        $returnurl->param('msg', 'activatesuccess');

        if ($badge->type == BADGE_TYPE_SITE) {
            // Review on cron if there are more than 1000 users who can earn a site-level badge.
            $sql = 'SELECT COUNT(u.id) as num
                        FROM {user} u
                        LEFT JOIN {badge_issued} bi
                            ON u.id = bi.userid AND bi.badgeid = :badgeid
                        WHERE bi.badgeid IS NULL AND u.id != :guestid AND u.deleted = 0';
            $toearn = $DB->get_record_sql($sql, array('badgeid' => $badge->id, 'guestid' => $CFG->siteguest));

            if ($toearn->num < 1000) {
                $awards = $badge->review_all_criteria();
                $returnurl->param('awards', $awards);
            } else {
                $returnurl->param('awards', 'cron');
            }
        } else {
            $awards = $badge->review_all_criteria();
            $returnurl->param('awards', $awards);
        }
        redirect($returnurl);
    }

    $strheading = get_string('reviewbadge', 'badges');
    $PAGE->navbar->add($strheading);
    $PAGE->set_title($strheading);
    $PAGE->set_heading($badge->name);
    echo $OUTPUT->header();
    echo $OUTPUT->heading($strheading);

    $params = array('id' => $badge->id, 'activate' => 1, 'sesskey' => sesskey(), 'confirm' => 1, 'return' => $return);
    $url = new lion_url('/badges/action.php', $params);

    if (!$badge->has_criteria()) {
        echo $OUTPUT->notification(get_string('error:cannotact', 'badges') . get_string('nocriteria', 'badges'));
        echo $OUTPUT->continue_button($returnurl);
    } else {
        $message = get_string('reviewconfirm', 'badges', $badge->name);
        echo $OUTPUT->confirm($message, $url, $returnurl);
    }
    echo $OUTPUT->footer();
    die;
}

if ($deactivate) {
    require_sesskey();
    require_capability('lion/badges:configurecriteria', $context);

    $status = ($badge->status == BADGE_STATUS_ACTIVE) ? BADGE_STATUS_INACTIVE : BADGE_STATUS_INACTIVE_LOCKED;
    $badge->set_status($status);
    redirect($returnurl);
}
