<?php

/**
 * mod_scorm data generator.
 *
 * @package    mod_scorm
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * mod_scorm data generator class.
 *
 * @package    mod_scorm
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */
class mod_scorm_generator extends testing_module_generator {

    public function create_instance($record = null, array $options = null) {
        global $CFG, $USER;
        require_once($CFG->dirroot.'/mod/scorm/lib.php');
        require_once($CFG->dirroot.'/mod/scorm/locallib.php');
        $cfgscorm = get_config('scorm');

        // Add default values for scorm.
        $record = (array)$record + array(
            'scormtype' => SCORM_TYPE_LOCAL,
            'packagefile' => '',
            'packagefilepath' => $CFG->dirroot.'/mod/scorm/tests/packages/singlescobasic.zip',
            'packageurl' => '',
            'updatefreq' => SCORM_UPDATE_NEVER,
            'popup' => 0,
            'width' => $cfgscorm->framewidth,
            'height' => $cfgscorm->frameheight,
            'skipview' => $cfgscorm->skipview,
            'hidebrowse' => $cfgscorm->hidebrowse,
            'displaycoursestructure' => $cfgscorm->displaycoursestructure,
            'hidetoc' => $cfgscorm->hidetoc,
            'nav' => $cfgscorm->nav,
            'navpositionleft' => $cfgscorm->navpositionleft,
            'navpositiontop' => $cfgscorm->navpositiontop,
            'displayattemptstatus' => $cfgscorm->displayattemptstatus,
            'timeopen' => 0,
            'timeclose' => 0,
            'grademethod' => GRADESCOES,
            'maxgrade' => $cfgscorm->maxgrade,
            'maxattempt' => $cfgscorm->maxattempt,
            'whatgrade' => $cfgscorm->whatgrade,
            'forcenewattempt' => $cfgscorm->forcenewattempt,
            'lastattemptlock' => $cfgscorm->lastattemptlock,
            'forcecompleted' => $cfgscorm->forcecompleted,
            'auto' => $cfgscorm->auto,
            'displayactivityname' => $cfgscorm->displayactivityname
        );

        // The 'packagefile' value corresponds to the draft file area ID. If not specified, create from packagefilepath.
        if (empty($record['packagefile']) && $record['scormtype'] === SCORM_TYPE_LOCAL) {
            if (!isloggedin() || isguestuser()) {
                throw new coding_exception('Scorm generator requires a current user');
            }
            if (!file_exists($record['packagefilepath'])) {
                throw new coding_exception("File {$record['packagefilepath']} does not exist");
            }
            $usercontext = context_user::instance($USER->id);

            // Pick a random context id for specified user.
            $record['packagefile'] = file_get_unused_draft_itemid();

            // Add actual file there.
            $filerecord = array('component' => 'user', 'filearea' => 'draft',
                    'contextid' => $usercontext->id, 'itemid' => $record['packagefile'],
                    'filename' => basename($record['packagefilepath']), 'filepath' => '/');
            $fs = get_file_storage();
            $fs->create_file_from_pathname($filerecord, $record['packagefilepath']);
        }

        return parent::create_instance($record, (array)$options);
    }
}
