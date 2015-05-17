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
 * Object representation of an IMAP mailbox string used in a LIST command.
 *
 * @category  Horde
 */
class Horde_Imap_Client_Data_Format_ListMailbox extends Horde_Imap_Client_Data_Format_Mailbox
{
    /**
     */
    protected function _filterParams()
    {
        $ob = parent::_filterParams();

        /* Don't quote % or * characters. */
        $ob->no_quote_list = true;

        return $ob;
    }

}
