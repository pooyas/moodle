<?php
/**
 * Copyright 2011-2014 Horde LLC (http://www.horde.org/)
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
 * Object containg POP3 fetch data.
 *
 * @category  Horde
 */
class Horde_Imap_Client_Data_Fetch_Pop3 extends Horde_Imap_Client_Data_Fetch
{
    /**
     * Set UID.
     *
     * @param string $uid  The message UID. Unlike IMAP, this UID does not
     *                     have to be an integer.
     */
    public function setUid($uid)
    {
        $this->_data[Horde_Imap_Client::FETCH_UID] = strval($uid);
    }

}
