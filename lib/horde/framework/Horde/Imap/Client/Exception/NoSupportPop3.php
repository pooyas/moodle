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
 * Exception thrown for non-supported IMAP features on POP3 servers.
 *
 * @category  Horde
 */
class Horde_Imap_Client_Exception_NoSupportPop3
extends Horde_Imap_Client_Exception
{
    /**
     * Constructor.
     *
     * @param string $feature  The feature not supported in POP3.
     */
    public function __construct($feature)
    {
        parent::__construct(
            sprintf(Horde_Imap_Client_Translation::r("%s not supported on POP3 servers."), $feature),
            self::NOT_SUPPORTED
        );
    }

}
