<?php


/**
 * Return token
 * @package    core
 * @subpackage login
 * @copyright  2015 Pooya Saeedi
 */

define('AJAX_SCRIPT', true);
define('REQUIRE_CORRECT_ACCESS', true);
define('NO_LION_COOKIES', true);

require_once(dirname(dirname(__FILE__)) . '/config.php');

$username = required_param('username', PARAM_USERNAME);
$password = required_param('password', PARAM_RAW);
$serviceshortname  = required_param('service',  PARAM_ALPHANUMEXT);

echo $OUTPUT->header();

if (!$CFG->enablewebservices) {
    throw new lion_exception('enablewsdescription', 'webservice');
}
$username = trim(core_text::strtolower($username));
if (is_restored_user($username)) {
    throw new lion_exception('restoredaccountresetpassword', 'webservice');
}
$user = authenticate_user_login($username, $password);
if (!empty($user)) {

    //Non admin can not authenticate if maintenance mode
    $hassiteconfig = has_capability('lion/site:config', context_system::instance(), $user);
    if (!empty($CFG->maintenance_enabled) and !$hassiteconfig) {
        throw new lion_exception('sitemaintenance', 'admin');
    }

    if (isguestuser($user)) {
        throw new lion_exception('noguest');
    }
    if (empty($user->confirmed)) {
        throw new lion_exception('usernotconfirmed', 'lion', '', $user->username);
    }
    // check credential expiry
    $userauth = get_auth_plugin($user->auth);
    if (!empty($userauth->config->expiration) and $userauth->config->expiration == 1) {
        $days2expire = $userauth->password_expire($user->username);
        if (intval($days2expire) < 0 ) {
            throw new lion_exception('passwordisexpired', 'webservice');
        }
    }

    // Check whether the user should be changing password.
    if (get_user_preferences('auth_forcepasswordchange', false, $user)) {
        if ($userauth->can_change_password()) {
            throw new lion_exception('forcepasswordchangenotice');
        } else {
            throw new lion_exception('nopasswordchangeforced', 'auth');
        }
    }

    // let enrol plugins deal with new enrolments if necessary
    enrol_check_plugins($user);

    // setup user session to check capability
    \core\session\manager::set_user($user);

    //check if the service exists and is enabled
    $service = $DB->get_record('external_services', array('shortname' => $serviceshortname, 'enabled' => 1));
    if (empty($service)) {
        // will throw exception if no token found
        throw new lion_exception('servicenotavailable', 'webservice');
    }

    //check if there is any required system capability
    if ($service->requiredcapability and !has_capability($service->requiredcapability, context_system::instance(), $user)) {
        throw new lion_exception('missingrequiredcapability', 'webservice', '', $service->requiredcapability);
    }

    //specific checks related to user restricted service
    if ($service->restrictedusers) {
        $authoriseduser = $DB->get_record('external_services_users',
            array('externalserviceid' => $service->id, 'userid' => $user->id));

        if (empty($authoriseduser)) {
            throw new lion_exception('usernotallowed', 'webservice', '', $serviceshortname);
        }

        if (!empty($authoriseduser->validuntil) and $authoriseduser->validuntil < time()) {
            throw new lion_exception('invalidtimedtoken', 'webservice');
        }

        if (!empty($authoriseduser->iprestriction) and !address_in_subnet(getremoteaddr(), $authoriseduser->iprestriction)) {
            throw new lion_exception('invalidiptoken', 'webservice');
        }
    }

    //Check if a token has already been created for this user and this service
    //Note: this could be an admin created or an user created token.
    //      It does not really matter we take the first one that is valid.
    $tokenssql = "SELECT t.id, t.sid, t.token, t.validuntil, t.iprestriction
              FROM {external_tokens} t
             WHERE t.userid = ? AND t.externalserviceid = ? AND t.tokentype = ?
          ORDER BY t.timecreated ASC";
    $tokens = $DB->get_records_sql($tokenssql, array($user->id, $service->id, EXTERNAL_TOKEN_PERMANENT));

    //A bit of sanity checks
    foreach ($tokens as $key=>$token) {

        /// Checks related to a specific token. (script execution continue)
        $unsettoken = false;
        //if sid is set then there must be a valid associated session no matter the token type
        if (!empty($token->sid)) {
            if (!\core\session\manager::session_exists($token->sid)){
                //this token will never be valid anymore, delete it
                $DB->delete_records('external_tokens', array('sid'=>$token->sid));
                $unsettoken = true;
            }
        }

        //remove token if no valid anymore
        //Also delete this wrong token (similar logic to the web service servers
        //    /webservice/lib.php/webservice_server::authenticate_by_token())
        if (!empty($token->validuntil) and $token->validuntil < time()) {
            $DB->delete_records('external_tokens', array('token'=>$token->token, 'tokentype'=> EXTERNAL_TOKEN_PERMANENT));
            $unsettoken = true;
        }

        // remove token if its ip not in whitelist
        if (isset($token->iprestriction) and !address_in_subnet(getremoteaddr(), $token->iprestriction)) {
            $unsettoken = true;
        }

        if ($unsettoken) {
            unset($tokens[$key]);
        }
    }

    // if some valid tokens exist then use the most recent
    if (count($tokens) > 0) {
        $token = array_pop($tokens);
    } else {
        if ( ($serviceshortname == LION_OFFICIAL_MOBILE_SERVICE and has_capability('lion/webservice:createmobiletoken', context_system::instance()))
                //Note: automatically token generation is not available to admin (they must create a token manually)
                or (!is_siteadmin($user) && has_capability('lion/webservice:createtoken', context_system::instance()))) {
            // if service doesn't exist, dml will throw exception
            $service_record = $DB->get_record('external_services', array('shortname'=>$serviceshortname, 'enabled'=>1), '*', MUST_EXIST);

            // Create a new token.
            $token = new stdClass;
            $token->token = md5(uniqid(rand(), 1));
            $token->userid = $user->id;
            $token->tokentype = EXTERNAL_TOKEN_PERMANENT;
            $token->contextid = context_system::instance()->id;
            $token->creatorid = $user->id;
            $token->timecreated = time();
            $token->externalserviceid = $service_record->id;
            // MDL-43119 Token valid for 3 months (12 weeks).
            $token->validuntil = $token->timecreated + 12 * WEEKSECS;
            $token->id = $DB->insert_record('external_tokens', $token);

            $params = array(
                'objectid' => $token->id,
                'relateduserid' => $user->id,
                'other' => array(
                    'auto' => true
                )
            );
            $event = \core\event\webservice_token_created::create($params);
            $event->add_record_snapshot('external_tokens', $token);
            $event->trigger();
        } else {
            throw new lion_exception('cannotcreatetoken', 'webservice', '', $serviceshortname);
        }
    }

    // log token access
    $DB->set_field('external_tokens', 'lastaccess', time(), array('id'=>$token->id));

    $params = array(
        'objectid' => $token->id,
    );
    $event = \core\event\webservice_token_sent::create($params);
    $event->add_record_snapshot('external_tokens', $token);
    $event->trigger();

    $usertoken = new stdClass;
    $usertoken->token = $token->token;
    echo json_encode($usertoken);
} else {
    throw new lion_exception('usernamenotfound', 'lion');
}
