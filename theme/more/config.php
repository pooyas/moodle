<?php

/**
 * Theme More config file.
 *
 * @package    theme_more
 * @copyright  2015 Pooya Saeedi
 * 
 */

$THEME->name = 'more';
$THEME->parents = array('clean', 'bootstrapbase');

$THEME->doctype = 'html5';
$THEME->sheets = array('custom');
$THEME->lessfile = 'lion';
$THEME->parents_exclude_sheets = array('bootstrapbase' => array('lion'), 'clean' => array('custom'));
$THEME->lessvariablescallback = 'theme_more_less_variables';
$THEME->extralesscallback = 'theme_more_extra_less';
$THEME->supportscssoptimisation = false;
$THEME->yuicssmodules = array();
$THEME->enable_dock = true;
$THEME->editor_sheets = array();

$THEME->rendererfactory = 'theme_overridden_renderer_factory';
$THEME->csspostprocess = 'theme_more_process_css';
