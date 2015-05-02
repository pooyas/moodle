<?php


/**
 * LION VERSION INFORMATION
 *
 * This file defines the current version of the core Lion code being used.
 * This is compared against the values stored in the database to determine
 * whether upgrades should be performed (see lib/db/*.php)
 *
 * @package    core
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * 
 */

defined('LION_INTERNAL') || die();

$version  = 2015031900.00;              // YYYYMMDD      = weekly release date of this DEV branch.
                                        //         RR    = release increments - 00 in DEV branches.
                                        //           .XX = incremental changes.

$release  = '2.9dev (Build: 20150319)'; // Human-friendly version name

$branch   = '29';                       // This version's branch.
$maturity = MATURITY_ALPHA;             // This version's maturity level.
