<?php
/**
 * Copyright 2012-2014 Horde LLC (http://www.horde.org/)
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
 * Object representation of an IMAP number (RFC 3501 [4.2]).
 *
 * @category  Horde
 */
class Horde_Imap_Client_Data_Format_Number extends Horde_Imap_Client_Data_Format
{
    /**
     */
    public function __toString()
    {
        return strval(intval($this->_data));
    }

    /**
     */
    public function verify()
    {
        if (!is_numeric($this->_data)) {
            throw new Horde_Imap_Client_Data_Format_Exception('Illegal character in IMAP number.');
        }
    }

}
