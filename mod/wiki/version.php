<?php

/**
 * Code fragment to define the version of wiki
 * This fragment is called by lion_needs_upgrading() and /admin/index.php
 *
 * @package    mod_wiki
 * @copyright  2009 Marc Alier, Jordi Piguillem marc.alier@upc.edu
 * @copyright  2009 Universitat Politecnica de Catalunya http://www.upc.edu
 *
 * @author Jordi Piguillem
 * @author Marc Alier
 * @author David Jimenez
 * @author Josep Arus
 * @author Kenneth Riba
 *
 * 
 */

defined('LION_INTERNAL') || die();

$plugin->version   = 2014111000;       // The current module version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400;    // Requires this Lion version
$plugin->component = 'mod_wiki';       // Full name of the plugin (used for diagnostics)
$plugin->cron      = 0;
