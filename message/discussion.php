<?php

/**
 * This file was replaced by index.php in Lion 2.0 and now simply redirects to index.php
 *
 * @package    core_message
 * @copyright  2005 Luis Rodrigues and Martin Dougiamas
 * 
 */

    require(dirname(dirname(__FILE__)) . '/config.php');
    require_once($CFG->dirroot . '/message/lib.php');

    //the same URL params as in 1.9
    $userid     = required_param('id', PARAM_INT);
    $noframesjs = optional_param('noframesjs', 0, PARAM_BOOL);

    $params = array('user2'=>$userid);
    if (!empty($noframesjs)) {
        $params['noframesjs'] = $noframesjs;
    }
    $url = new lion_url('/message/index.php', $params);
    redirect($url);
?>
