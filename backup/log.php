<?php

/**
 * old scheduled backups report. Now redirecting
 * to the new admin one
 * 
 * @package     core
 * @subpackage  backup
 * @copyright   2015 Pooya Saeedi
 */
       
       // log.php - 
       // 

    require_once("../config.php");

    require_login();

    require_capability('lion/backup:backupcourse', context_system::instance());

    redirect("$CFG->wwwroot/report/backups/index.php", '', 'admin', 1);
