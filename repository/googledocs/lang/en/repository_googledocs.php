<?php

/**
 * Strings for component 'repository_googledocs', language 'en', branch 'LION_20_STABLE'
 *
 * @package   repository_googledocs
 * @copyright 2015 Pooya Saeedi
 * 
 */

$string['clientid'] = 'Client ID';
$string['configplugin'] = 'Configure Google Drive plugin';
$string['googledocs:view'] = 'View Google Drive repository';
$string['oauthinfo'] = '<p>To use this plugin, you must register your site with Google, as described in the documentation <a href="{$a->docsurl}">Google OAuth 2.0 setup</a>.</p><p>As part of the registration process, you will need to enter the following URL as \'Authorized Redirect URIs\':</p><p>{$a->callbackurl}</p><p>Once registered, you will be provided with a client ID and secret which can be used to configure all Google Drive and Picasa plugins.</p><p>Please also note that you will have to enable the service \'Drive API\'.</p>';
$string['oauth2upgrade_message_subject'] = 'Important information regarding Google Drive repository plugin';
$string['oauth2upgrade_message_content'] = 'As part of the upgrade to Lion 2.3, the Google Drive portfolio plugin has been disabled. To re-enable it, your Lion site needs to be registered with Google, as described in the documentation {$a->docsurl}, in order to obtain a client ID and secret. The client ID and secret can then be used to configure all Google Drive and Picasa plugins.';
$string['oauth2upgrade_message_small'] = 'This plugin has been disabled, as it requires configuration as described in the documentation Google OAuth 2.0 setup.';
$string['pluginname'] = 'Google Drive';
$string['secret'] = 'Secret';
$string['servicenotenabled'] = 'Access not configured. Make sure the service \'Drive API\' is enabled.';
