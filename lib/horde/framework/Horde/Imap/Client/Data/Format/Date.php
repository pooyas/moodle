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
 * Object representation of an IMAP date string (RFC 3501 [9]).
 *
 * @category  Horde
 */
class Horde_Imap_Client_Data_Format_Date extends Horde_Imap_Client_Data_Format
{
    /**
     * Constructor.
     *
     * @param mixed $data  Either a DateTime object, or a date format that
     *                     can be converted to a DateTime object.
     *
     * @throws Exception
     */
    public function __construct($data)
    {
        if (!($data instanceof DateTime)) {
            $data = new Horde_Imap_Client_DateTime($data);
        }

        parent::__construct($data);
    }

    /**
     */
    public function __toString()
    {
        return $this->_data->format('j-M-Y');
    }

}
