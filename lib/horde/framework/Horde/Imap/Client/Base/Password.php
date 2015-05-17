<?php
/**
 * Copyright 2013-2014 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category  Horde
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Interface to allow dynamic generation of server password.
 *
 * @category  Horde
 */
interface Horde_Imap_Client_Base_Password
{
    /**
     * Return the password to use for the server connection.
     *
     * @return string  The password.
     */
    public function getPassword();

}
