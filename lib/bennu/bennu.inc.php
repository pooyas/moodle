<?php

/**
 *  BENNU - PHP iCalendar library
 *  (c) 2005-2006 Ioannis Papaioannou (pj@lion.org). All rights reserved.
 *
 *  Released under the LGPL.
 *
 *  See http://bennu.sourceforge.net/ for more information and downloads.
 *
 * @version $Id$
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

if(!defined('_BENNU_VERSION')) {
    define('_BENNU_VERSION', '0.1');
    include('bennu.class.php');
    include('iCalendar_rfc2445.php');
    include('iCalendar_components.php');
    include('iCalendar_properties.php');
    include('iCalendar_parameters.php');
}
