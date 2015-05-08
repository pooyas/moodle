<?php

/**
 * Spellchecker configuration. (Has been rewritten for Lion.)
 *
 * @package   tinymce
 * @subpackage spellchecker
 * @copyright 2015 Pooya Saeedi
 * 
 */

require('../../../../../config.php');

@error_reporting(E_ALL ^ E_NOTICE); // Hide notices even if Lion is configured to show them.

// General settings
$engine = get_config('tinymce_spellchecker', 'spellengine');
if (!$engine or $engine === 'GoogleSpell') {
    $engine = 'PSpell';
}
$config['general.engine'] = $engine;

if ($config['general.engine'] === 'PSpell') {
    // PSpell settings
    $config['PSpell.mode'] = PSPELL_FAST;
    $config['PSpell.spelling'] = "";
    $config['PSpell.jargon'] = "";
    $config['PSpell.encoding'] = "";
} else if ($config['general.engine'] === 'PSpellShell') {
    // PSpellShell settings
    $config['PSpellShell.mode'] = PSPELL_FAST;
    $config['PSpellShell.aspell'] = $CFG->aspellpath;
    $config['PSpellShell.tmp'] = '/tmp';
}
