<?php
//This is part of Moodle utilities development

/*
* Calling the update server to get the updater and list of available updates
*
* @author: Pooya Saeedi
* @copyright: 2015
* @version: 1.0
*/

/**
 * Gets the parameters from the command line and put it into arrays.
* The known parameters shoud be passed in $longoptions
* @param array $longoptions : known options and their defaults (--help)
* @param array $shortmapping : short options (-h)
* @return $options,$unrecognized as arrays
*/
define('CLI_SCRIPT', true);
define('ABORT_AFTER_CONFIG', true);
define('LION_INTERNAL', true);

if(!defined('UPDATER_CALL'))
{
function cli_get_params(array $longoptions, array $shortmapping=null) {

	$shortmapping = (array)$shortmapping;
	$options      = array();
	$unrecognized = array();

	if (empty($_SERVER['argv'])) {
		return array($options, $unrecognized);
	}
	$rawoptions = $_SERVER['argv'];

	//remove anything after '--', options can not be there
	if (($key = array_search('--', $rawoptions)) !== false) {
		$rawoptions = array_slice($rawoptions, 0, $key);
	}

	//remove script
	unset($rawoptions[0]);
	foreach ($rawoptions as $raw) {
		if (substr($raw, 0, 2) === '--') {
			$value = substr($raw, 2);
			$parts = explode('=', $value);
			if (count($parts) == 1) {
				$key   = reset($parts);
				$value = true;
			} else {
				$key = array_shift($parts);
				$value = implode('=', $parts);
			}
			if (array_key_exists($key, $longoptions)) {
				$options[$key] = $value;
			} else {
				$unrecognized[] = $raw;
			}

		} else if (substr($raw, 0, 1) === '-') {
			$value = substr($raw, 1);
			$parts = explode('=', $value);
			if (count($parts) == 1) {
				$key   = reset($parts);
				$value = true;
			} else {
				$key = array_shift($parts);
				$value = implode('=', $parts);
			}
			if (array_key_exists($key, $shortmapping)) {
				$options[$shortmapping[$key]] = $value;
			} else {
				$unrecognized[] = $raw;
			}
		} else {
			$unrecognized[] = $raw;
			continue;
		}
	}
	//apply defaults
	foreach ($longoptions as $key=>$default) {
		if (!array_key_exists($key, $options)) {
			$options[$key] = $default;
		}
	}
	// finished
	return array($options, $unrecognized);
}

function deletedir($path)
{
	return is_file($path) ?
	@unlink($path) :
	array_map(__FUNCTION__, glob($path.'/*')) == @rmdir($path);
}

/**
 * Gets the md5 of a directory
 * @param unknown $directory
 * @return boolean|string
 */

function md5_directory($directory)
{
	if (! is_dir($directory))
	{
		return false;
	}
	$files = array();
	$dir = dir($directory);
	
	while(false !== ($file = $dir->read()))
	{
		if($file != '.' and $file != '..')
		{
			if(is_dir($directory.'/'.$file))
			{
				$files[] = md5_directory($directory.'/'.$file);
			}
			else 
			{
				$files[] = md5_file($directory.'/'.$file);
			}
		}
	}
	$dir->close();
	
	return md5(implode('',$files));
}

function now()
{
	return date("Y/m/d h:i:s: ");
}
}//endif updater_call

if(!defined('UPDATER_CALL'))
{
	echo now()."update-cli started\n";
	$help = 'Usage: update-cli --sourcedir=<source root folder> --updatesrv=<update server>';


	list($options,$unrecognized) = cli_get_params(
		array(
				'sourcedir'	=>dirname(dirname(dirname(__FILE__))),
				'updatesrv'	=> '',
				'help'			=>false
		),
		array(
				'h'				=>'help'
		)
	);

	if ($unrecognized) {
		$unrecognized = implode("\n  ", $unrecognized);
		echo $unrecognized;
		die(now()."Script died. Unrecognized parameters\n");
	}

	if(empty ($options['updatesrv']) or $options['help']){
		echo $help;
		die(now()."Script died. Empty parameters or help\n");
	}

	$sourcedir = $options['sourcedir'];
	$updatesrv = $options['updatesrv'];

	if(!is_dir($sourcedir))
	{
		die(now()."Script died. Not a valid source path\n");
	}
}
require_once ($sourcedir.'/config.php');

//Checking the existence of update api key
//If it doesn't exists there is no point in continuing
if (!file_exists($CFG->dataroot.'/keys/update.api'))
	die(now()."Script died. No API Key found!\n");

//XML Template
$xmldata = <<<XML
<?xml version='1.0' standalone='yes'?>
<update>
 <updversion>1.0</updversion>
 <coreversion></coreversion>
 <langmd5></langmd5>
 <returnupdpass></returnupdpass>		
 <plugins>
 </plugins>
</update>
XML;

//Getting core version
require_once ($sourcedir.'/version.php');


$xml = new SimpleXMLElement($xmldata);
$xml->coreversion = $version;

//Array of plugin paths in the system
$pluginpath = array(
		'/mod', '/mod/assign/submission', '/mod/assign/feedback',
		'/mod/book/tool', '/mod/data/preset', '/mod/data/field', '/mod/lti/source',
		'/mod/quiz/report', '/mod/quiz/accessrule','/mod/scorm/report', '/mod/workshop/allocation',
		'/mod/workshop/eval','/mod/workshop/form',
		'/admin/tool',
		'/auth',
		'/availability/condition',
		'/blocks',
		'/cache/stores', '/cache/locks',
		'/calendar/type',
		'/course/format', '/course/report',
		'/enrol',  '/filter',
		'/grade/export', '/grade/import', '/grade/report', '/grade/grading/form',
		'/lib/editor', '/lib/editor/atto/plugins', '/lib/editor/tinymce/plugins',
		'/local',
		'/message/output',
		'/plagiarism',
		'/portfolio',
		'/question/behaviour', '/question/format', '/question/type',
		'/report',
		'/repository',
		'/theme',
		'/user/profile/field',
		'/webservice'
);

//Getting plugin version
echo (now()."Getting plugin versions\n");
foreach($pluginpath as $plugincat)
{
	$prefix = substr(str_replace('/', '_', $plugincat),1);
	if(!is_dir($sourcedir.$plugincat))
		continue;
	foreach (scandir($sourcedir.$plugincat) as $_plugin)
	{
		if(!is_dir($sourcedir.$plugincat.'/'.$_plugin))
			continue;
		if(($_plugin == '.')||($_plugin == '..')||($_plugin == 'tests')||($_plugin=='yui'))
			continue;
		$pluginname = $prefix.'_'.$_plugin;
		if(file_exists($sourcedir.$plugincat.'/'.$_plugin.'/version.php'))
				require_once($sourcedir.$plugincat.'/'.$_plugin.'/version.php');
		$new_plugin=$xml->plugins->addChild('plugin');
		$new_plugin->addChild('name',$pluginname);
		$new_plugin->addChild('version',$plugin->version);		
	}
}
echo (now()."Done\n");

//Get MD5 of lang directory
echo (now()."Getting MD5 of lang directory\n");
$langdir = $CFG->dataroot.'/lang';
$xml->langmd5 = md5_directory($langdir);
echo (now()."Done\n");

//Generating return updater zip password
echo (now()."Generating return password\n");
$return_updater_password = bin2hex(openssl_random_pseudo_bytes(4));
$xml->returnupdpass = $return_updater_password;
echo (now()."Done\n");

//Get API Key
echo (now()."Getting API key information\n");
$api_key = file_get_contents($CFG->dataroot.'/keys/update.api');
$api_key = str_replace("\n", "", $api_key); //I don't still understand why I have to do this
echo (now()."Done\n");

//Get Public Key data
echo (now()."Getting publick key data\n");
$pubfile = fopen($CFG->dataroot.'/keys/update.pub','r');
$pub_key = fread($pubfile,8192);
$key = openssl_get_publickey($pub_key);

if(!$key)
	die(now()."Script died. Failed extracting public key\n");
echo (now()."Done\n");
//Sealing the request with public key
echo (now()."Sealing request\n");
if(!openssl_seal($xml->asXML(), $request_encrypted, $env_key, array($key)))
	die(now()."Script died. Failed in sealing\n");
echo (now()."Done\n");
//We are done with the key so let's free the memory
openssl_free_key($key);

//Prepare request to send to the server
//The download may take some time so increasing the time limit
set_time_limit(0);
$updroot_dir = $CFG->dataroot.'/update';
echo (now()."Checking existance/create of update root folder\n");
if(!file_exists($updroot_dir)||!is_dir($updroot_dir))
{
	if(!mkdir($updroot_dir))
		die(now()."Cannot make root update directory\n");
}
echo (now()."Done\n");

echo (now()."Creating temp backup folder\n");
//A random folder name for updater package
$upd_folder = microtime();
//This is for the shell command for unzipping which doesn't like spaces
$upd_folder = str_replace(' ', '', $upd_folder);

if(!mkdir($updroot_dir.'/'.$upd_folder))
	die(now()."Script died. Cannot make update folder\n");
echo (now()."Done\n");
$upd_path = $updroot_dir.'/'.$upd_folder;
echo (now()."Preparing cURL request\n");
$update_file_pointer = fopen($upd_path.'/update.upd','w+');

//Preparing the query to send
$query = http_build_query(array('req'=>$request_encrypted,'envkey'=>$env_key[0],'apikey'=>$api_key));

//Setting up curl to perform the request
$ch = curl_init($updatesrv);
curl_setopt($ch, CURLOPT_TIMEOUT, 120);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
curl_setopt($ch, CURLOPT_FILE, $update_file_pointer);

echo (now()."Done\n");
echo (now()."Executing cURL\n");
if(!curl_exec($ch))
{
	@unlink($upd_path.'/update.upd');
	@unlink($upd_path);
	die(now()."Script died. CURL failed\n");
}
echo (now()."Done\n");
$curl_info = curl_getinfo($ch);
curl_close($ch);
fclose($update_file_pointer);

//If there is an error then display it
if($curl_info["http_code"]>900)
{
	@unlink($upd_path.'/update.upd');
	@unlink($upd_path);
	die(now()."Script died. Error: ".$curl_info["http_code"]."\n");
}

//Unzipping the updater
echo (now()."Unpacking updater\n");
@system("unzip -qq -d $upd_path -P $return_updater_password $upd_path/update.upd", $return_code);

@unlink($upd_path.'/update.upd');

if($return_code!=0)
{
	@unlink($upd_path);
	die(now()."Script died. Failed on unzip\n");
}
echo (now()."Done\n");
echo (now()."Executing updater\n");
//Executing updater
try 
{
	if(!defined('UPDATER_CALL'))
		$_upd_path = $upd_path;
	include($upd_path.'/updater.php');
}
catch(Exception $e)
{
	echo(now()."Exception: ".$e->getMessage()."\n");
}
finally {
	//Cleaning up
	echo (now()."Cleaning up\n");
	deletedir($upd_path);
	if(defined('UPDATER_CALL'))
		deletedir($_upd_path);
	echo (now()."Done\n");
}
echo (now()."End of main script\n");