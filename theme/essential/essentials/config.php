<?php


/**
 * Essentials is a basic child theme of Essential to help you as a theme
 * developer create your own child theme of Essential.
 *
 * @package    theme
 * @subpackage essential
 * @copyright  2015 Pooya Saeedi
 */

$THEME->name = 'essentials';

$THEME->yuicssmodules = array();
$THEME->parents = array('essential');

$THEME->sheets[] = 'essentials';

/* If you need all of the Essential settings values, then comment this ($THEME->parents_exclude_sheets)
   out and look at 'theme_essentials_process_css' in lib.php for more information. */
$THEME->parents_exclude_sheets = array(
    'essential' => array(
        'essential-settings',
        'custom'
    )
);

$THEME->supportscssoptimisation = false;

/* Other layouts will use the Essential ones, so it is important that the header.php file keeps things the same,
   like 'essentialnavbar'.
   If you are only looking to change the styles by adding your own to 'essentials.css' in the styles folder, then
   you can remove this ($THEME->layouts). */
$THEME->layouts = array(
    // Front page.
    'frontpage' => array(
        'file' => 'frontpage.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre'
    ),
    // The pagelayout used for safebrowser and securewindow.
    'secure' => array(
        'file' => 'secure.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-pre'
    )
);

$THEME->rendererfactory = 'theme_overridden_renderer_factory';
$THEME->csspostprocess = 'theme_essentials_process_css';
