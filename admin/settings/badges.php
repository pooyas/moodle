<?php


/**
* This file defines settingpages and externalpages under the "badges" section
*
* @package    core
* @subpackage badges
* @copyright  2012 onwards Totara Learning Solutions Ltd {@link http://www.totaralms.com/}
* 
* @author     Yuliya Bozhko <yuliya.bozhko@totaralms.com>
*/

global $SITE;

if (($hassiteconfig || has_any_capability(array(
            'lion/badges:viewawarded',
            'lion/badges:createbadge',
            'lion/badges:manageglobalsettings',
            'lion/badges:awardbadge',
            'lion/badges:configurecriteria',
            'lion/badges:configuremessages',
            'lion/badges:configuredetails',
            'lion/badges:deletebadge'), $systemcontext))) {

    require_once($CFG->libdir . '/badgeslib.php');

    $globalsettings = new admin_settingpage('badgesettings', new lang_string('badgesettings', 'badges'),
            array('lion/badges:manageglobalsettings'), empty($CFG->enablebadges));

    $globalsettings->add(new admin_setting_configtext('badges_defaultissuername',
            new lang_string('defaultissuername', 'badges'),
            new lang_string('defaultissuername_desc', 'badges'),
            $SITE->fullname ? $SITE->fullname : $SITE->shortname, PARAM_TEXT));

    $globalsettings->add(new admin_setting_configtext('badges_defaultissuercontact',
            new lang_string('defaultissuercontact', 'badges'),
            new lang_string('defaultissuercontact_desc', 'badges'),
            get_config('lion','supportemail'), PARAM_EMAIL));

    $globalsettings->add(new admin_setting_configtext('badges_badgesalt',
            new lang_string('badgesalt', 'badges'),
            new lang_string('badgesalt_desc', 'badges'),
            'badges' . $SITE->timecreated, PARAM_ALPHANUM));

    $globalsettings->add(new admin_setting_configcheckbox('badges_allowexternalbackpack',
            new lang_string('allowexternalbackpack', 'badges'),
            new lang_string('allowexternalbackpack_desc', 'badges'), 1));

    $globalsettings->add(new admin_setting_configcheckbox('badges_allowcoursebadges',
            new lang_string('allowcoursebadges', 'badges'),
            new lang_string('allowcoursebadges_desc', 'badges'), 1));

    $ADMIN->add('badges', $globalsettings);

    $ADMIN->add('badges',
        new admin_externalpage('managebadges',
            new lang_string('managebadges', 'badges'),
            new lion_url('/badges/index.php', array('type' => BADGE_TYPE_SITE)),
            array(
                'lion/badges:viewawarded',
                'lion/badges:createbadge',
                'lion/badges:awardbadge',
                'lion/badges:configurecriteria',
                'lion/badges:configuremessages',
                'lion/badges:configuredetails',
                'lion/badges:deletebadge'
            ),
            empty($CFG->enablebadges)
        )
    );

    $ADMIN->add('badges',
        new admin_externalpage('newbadge',
            new lang_string('newbadge', 'badges'),
            new lion_url('/badges/newbadge.php', array('type' => BADGE_TYPE_SITE)),
            array('lion/badges:createbadge'), empty($CFG->enablebadges)
        )
    );
}
