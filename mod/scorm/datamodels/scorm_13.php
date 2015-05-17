<?php



/**
 * @package    mod
 * @subpackage scorm
 * @copyright  2015 Pooya Saeedi
*/

require_once($CFG->dirroot.'/mod/scorm/locallib.php');

$userdata = new stdClass();
$def = new stdClass();
$cmiobj = new stdClass();
$cmiint = new stdClass();
$cmicommentsuser = new stdClass();
$cmicommentslms = new stdClass();

if (!isset($currentorg)) {
    $currentorg = '';
}

if ($scoes = $DB->get_records('scorm_scoes', array('scorm' => $scorm->id), 'sortorder, id')) {
    // Drop keys so that it is a simple array.
    $scoes = array_values($scoes);
    foreach ($scoes as $sco) {
        $def->{($sco->id)} = new stdClass();
        $userdata->{($sco->id)} = new stdClass();
        $def->{($sco->id)} = get_scorm_default($userdata->{($sco->id)}, $scorm, $sco->id, $attempt, $mode);

        // Reconstitute objectives, comments_from_learner and comments_from_lms.
        $cmiobj->{($sco->id)} = scorm_reconstitute_array_element($scorm->version, $userdata->{($sco->id)},
                                                                    'cmi.objectives', array('score'));
        $cmiint->{($sco->id)} = scorm_reconstitute_array_element($scorm->version, $userdata->{($sco->id)},
                                                                    'cmi.interactions', array('objectives', 'correct_responses'));
        $cmicommentsuser->{($sco->id)} = scorm_reconstitute_array_element($scorm->version, $userdata->{($sco->id)},
                                                                    'cmi.comments_from_learner', array());
        $cmicommentslms->{($sco->id)} = scorm_reconstitute_array_element($scorm->version, $userdata->{($sco->id)},
                                                                    'cmi.comments_from_lms', array());
    }
}

$PAGE->requires->js_init_call('M.scorm_api.init', array($def, $cmiobj, $cmiint, $cmicommentsuser, $cmicommentslms,
                                                        scorm_debugging($scorm), $scorm->auto, $scorm->id, $CFG->wwwroot,
                                                        sesskey(), $scoid, $attempt, $mode, $id, $currentorg, $scorm->autocommit));


// Pull in the debugging utilities.
if (scorm_debugging($scorm)) {
    require_once($CFG->dirroot.'/mod/scorm/datamodels/debug.js.php');
    echo html_writer::script('AppendToLog("Lion SCORM 1.3 API Loaded, Activity: '.
                                $scorm->name.', SCO: '.$sco->identifier.'", 0);');
}
