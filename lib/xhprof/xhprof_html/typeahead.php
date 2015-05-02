<?php
//  Copyright (c) 2009 Facebook
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//

/**
 * AJAX endpoint for XHProf function name typeahead.
 *
 * @author(s)  Kannan Muthukkaruppan
 *             Changhao Jiang
 */

// Start lion modification: lionize this script.
require_once(dirname(dirname(dirname(dirname(__FILE__)))).'/config.php');
require_once($CFG->libdir . '/xhprof/xhprof_lion.php');
require_login();
require_capability('lion/site:config', context_system::instance());
// End lion modification.

// by default assume that xhprof_html & xhprof_lib directories
// are at the same level.
$GLOBALS['XHPROF_LIB_ROOT'] = dirname(__FILE__) . '/../xhprof_lib';

require_once $GLOBALS['XHPROF_LIB_ROOT'].'/display/xhprof.php';

// Start lion modification: use own XHProfRuns implementation.
// $xhprof_runs_impl = new XHProfRuns_Default();
$xhprof_runs_impl = new lion_xhprofrun();
// End lion modification.

require_once $GLOBALS['XHPROF_LIB_ROOT'].'/display/typeahead_common.php';
