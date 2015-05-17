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
 * Object representation of an IMAP atom (RFC 3501 [4.1]).
 *
 * @category  Horde
 */
class Horde_Imap_Client_Data_Format_Atom extends Horde_Imap_Client_Data_Format
{
    /**
     */
    public function escape()
    {
        return strlen($this->_data)
            ? parent::escape()
            : '""';
    }

    /**
     */
    public function verify()
    {
        if (strlen($this->_data) !== strlen($this->stripNonAtomCharacters())) {
            throw new Horde_Imap_Client_Data_Format_Exception('Illegal character in IMAP atom.');
        }
    }

    /**
     * Strip out any characters that are not allowed in an IMAP atom.
     *
     * @return string  The atom data disallowed characters removed.
     */
    public function stripNonAtomCharacters()
    {
        return str_replace(
            array('(', ')', '{', ' ', '%', '*', '"', '\\', ']'),
            '',
            preg_replace('/[^\x20-\x7e]/', '', $this->_data)
        );
    }

}
