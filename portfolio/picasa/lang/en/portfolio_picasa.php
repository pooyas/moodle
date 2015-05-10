<?php

/**
 * Strings for component 'portfolio_picasa', language 'en'
 *
 * @package   portfolio
 * @subpackage picasa
 * @copyright 2015 Pooya Saeedi
 * 
 */

$string['clientid'] = 'Client ID';
$string['noauthtoken'] = 'An authentication token has not been received from Google. Please ensure you are allowing Lion to access your Google account.';
$string['nooauthcredentials'] = 'OAuth credentials required.';
$string['nooauthcredentials_help'] = 'To use the Picasa portfolio plugin you must configure OAuth credentials in the portfolio settings.';
$string['oauthinfo'] = '<p>To use this plugin, you must register your site with Google, as described in the documentation <a href="{$a->docsurl}">Google OAuth 2.0 setup</a>.</p><p>As part of the registration process, you will need to enter the following URL as \'Authorized Redirect URIs\':</p><p>{$a->callbackurl}</p><p>Once registered, you will be provided with a client ID and secret which can be used to configure all Google Drive and Picasa plugins.</p>';
$string['oauth2upgrade_message_subject'] = 'Important information regarding Picasa portfolio plugin';
$string['oauth2upgrade_message_content'] = 'As part of the upgrade to Lion 2.3, the Picasa portfolio plugin has been disabled. To re-enable it, your Lion site needs to be registered with Google, as described in the documentation {$a->docsurl}, in order to obtain a client ID and secret. The client ID and secret can then be used to configure all Google Drive and Picasa plugins.';
$string['oauth2upgrade_message_small'] = 'This plugin has been disabled, as it requires configuration as described in the documentation Google OAuth 2.0 setup.';
$string['pluginname'] = 'Picasa';
$string['sendfailed'] = 'The file {$a} failed to transfer to Picasa';
$string['secret'] = 'Secret';
