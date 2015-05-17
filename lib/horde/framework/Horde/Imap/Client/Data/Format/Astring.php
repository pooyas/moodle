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
 * Object representation of an IMAP astring (atom or string) (RFC 3501 [4.3]).
 *
 * @category  Horde
 */
class Horde_Imap_Client_Data_Format_Astring extends Horde_Imap_Client_Data_Format_String
{
    /**
     */
    public function quoted()
    {
        return $this->_filter->quoted || !$this->_data->length();
    }

}
