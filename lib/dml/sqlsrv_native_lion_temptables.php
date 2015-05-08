<?php

/**
 * sqlsrv specific temptables store. Needed because temporary tables
 * are named differently than normal tables. Also used to be able to retrieve
 * temp table names included in the get_tables() method of the DB.
 *
 * @package    core
 * @subpackage dml
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

require_once(__DIR__.'/mssql_native_lion_temptables.php');

/**
 * This class is not specific to the SQL Server Native Driver but rather
 * to the family of Microsoft SQL Servers.
 *
 */
class sqlsrv_native_lion_temptables extends mssql_native_lion_temptables {}
