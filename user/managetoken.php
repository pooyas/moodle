<?php

/**
 * Web service test client.
 *
 * @package   core_webservice
 * @copyright 2015 Pooya Saeedi
 * @author    Jerome Mouneyrac
 * 
 */

require('../config.php');

require_login();
require_sesskey();

$usercontext = context_user::instance($USER->id);

$PAGE->set_context($usercontext);
$PAGE->set_url('/user/managetoken.php');
$PAGE->set_title(get_string('securitykeys', 'webservice'));
$PAGE->set_heading(get_string('securitykeys', 'webservice'));
$PAGE->set_pagelayout('admin');

$rsstokenboxhtml = $webservicetokenboxhtml = '';
// Manage user web service tokens.
if ( !is_siteadmin($USER->id)
    && !empty($CFG->enablewebservices)
    && has_capability('lion/webservice:createtoken', $usercontext )) {
    require($CFG->dirroot.'/webservice/lib.php');

    $action  = optional_param('action', '', PARAM_ALPHANUMEXT);
    $tokenid = optional_param('tokenid', '', PARAM_SAFEDIR);
    $confirm = optional_param('confirm', 0, PARAM_BOOL);

    $webservice = new webservice(); // Load the webservice library.
    $wsrenderer = $PAGE->get_renderer('core', 'webservice');

    if ($action == 'resetwstoken') {
        $token = $webservice->get_created_by_user_ws_token($USER->id, $tokenid);
        // Display confirmation page to Reset the token.
        if (!$confirm) {
            $resetconfirmation = $wsrenderer->user_reset_token_confirmation($token);
        } else {
            // Delete the token that need to be regenerated.
            $webservice->delete_user_ws_token($tokenid);
        }
    }

    // No point creating the table is we're just displaying a confirmation screen.
    if (empty($resetconfirmation)) {
        $webservice->generate_user_ws_tokens($USER->id); // Generate all token that need to be generated.
        $tokens = $webservice->get_user_ws_tokens($USER->id);
        foreach ($tokens as $token) {
            if ($token->restrictedusers) {
                $authlist = $webservice->get_ws_authorised_user($token->wsid, $USER->id);
                if (empty($authlist)) {
                    $token->enabled = false;
                }
            }
        }
        $webservicetokenboxhtml = $wsrenderer->user_webservice_tokens_box($tokens, $USER->id,
                $CFG->enablewsdocumentation); // Display the box for web service token.
    }
}

// RSS keys.
if (!empty($CFG->enablerssfeeds)) {
    require_once($CFG->dirroot.'/lib/rsslib.php');

    $action  = optional_param('action', '', PARAM_ALPHANUMEXT);
    $confirm = optional_param('confirm', 0, PARAM_BOOL);

    $rssrenderer = $PAGE->get_renderer('core', 'rss');

    if ($action == 'resetrsstoken') {
        // Display confirmation page to Reset the token.
        if (!$confirm) {
            $resetconfirmation = $rssrenderer->user_reset_rss_token_confirmation();
        } else {
            rss_delete_token($USER->id);
        }
    }
    if (empty($resetconfirmation)) {
        $token = rss_get_token($USER->id);
        $rsstokenboxhtml = $rssrenderer->user_rss_token_box($token); // Display the box for the user's RSS token.
    }
}

// PAGE OUTPUT.
echo $OUTPUT->header();
if (!empty($resetconfirmation)) {
    echo $resetconfirmation;
} else {
    echo $webservicetokenboxhtml;
    echo $rsstokenboxhtml;
}
echo $OUTPUT->footer();


