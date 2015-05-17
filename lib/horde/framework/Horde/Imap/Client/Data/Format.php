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
 * Object representation of an IMAP data format (RFC 3501 [4]).
 *
 * @category  Horde
 */
class Horde_Imap_Client_Data_Format
{
    /**
     * Data.
     *
     * @var mixed
     */
    protected $_data;

    /**
     * Constructor.
     *
     * @param mixed $data  Data.
     */
    public function __construct($data)
    {
        $this->_data = is_resource($data)
            ? stream_get_contents($data, -1, 0)
            : $data;
    }

    /**
     * Returns the string value of the raw data.
     *
     * @return string  String value.
     */
    public function __toString()
    {
        return strval($this->_data);
    }

    /**
     * Returns the raw data.
     *
     * @return mixed  Raw data.
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Returns the data formatted for output to the IMAP server.
     *
     * @return string  IMAP escaped string.
     */
    public function escape()
    {
        return strval($this);
    }

    /**
     * Verify the data.
     *
     * @throws Horde_Imap_Client_Data_Format_Exception
     */
    public function verify()
    {
    }

}
