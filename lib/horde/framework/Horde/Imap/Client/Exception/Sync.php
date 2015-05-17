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
 * Exception thrown for mailbox synchronization errors.
 *
 * @category  Horde
 */
class Horde_Imap_Client_Exception_Sync extends Horde_Exception_Wrapped
{
    /* Error message codes. */

    /**
     * Token could not be parsed.
     */
    const BAD_TOKEN = 1;

    /**
     * UIDVALIDITY of the mailbox changed.
     */
    const UIDVALIDITY_CHANGED = 2;

}
