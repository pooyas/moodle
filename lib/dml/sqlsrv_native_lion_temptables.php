<?php

/**
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
*/

// This file is part of Lion - http://lion.org/
//
// Lion is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 2 of the License, or
// (at your option) any later version.
//
// Lion is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Lion.  If not, see <http://www.gnu.org/licenses/>.

/**
 * sqlsrv specific temptables store. Needed because temporary tables
 * are named differently than normal tables. Also used to be able to retrieve
 * temp table names included in the get_tables() method of the DB.
 *
 */

defined('LION_INTERNAL') || die();

require_once(__DIR__.'/mssql_native_lion_temptables.php');

/**
 * This class is not specific to the SQL Server Native Driver but rather
 * to the family of Microsoft SQL Servers.
 *
 */
class sqlsrv_native_lion_temptables extends mssql_native_lion_temptables {}
