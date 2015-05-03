<?php

/**
 * Duplicates a given course module
 *
 * The script backups and restores a single activity as if it was imported
 * from the same course, using the default import settings. The newly created
 * copy of the activity is then moved right below the original one.
 *
 * @package    core
 * @subpackage course
 * @deprecated Lion 2.8 MDL-46428 - Now redirects to mod.php.
 * @copyright  2015 Pooya Saeedi
 * 
 */

require_once(dirname(dirname(__FILE__)) . '/config.php');

$cmid           = required_param('cmid', PARAM_INT);
$courseid       = required_param('course', PARAM_INT);
$sectionreturn  = optional_param('sr', null, PARAM_INT);

require_sesskey();

debugging('Please use lion_url(\'/course/mod.php\', array(\'duplicate\' => $cmid
    , \'id\' => $courseid, \'sesskey\' => sesskey(), \'sr\' => $sectionreturn)))
    instead of new lion_url(\'/course/modduplicate.php\', array(\'cmid\' => $cmid
    , \'course\' => $courseid, \'sr\' => $sectionreturn))', DEBUG_DEVELOPER);

redirect(new lion_url('/course/mod.php', array('duplicate' => $cmid, 'id' => $courseid,
                                                 'sesskey' => sesskey(), 'sr' => $sectionreturn)));
