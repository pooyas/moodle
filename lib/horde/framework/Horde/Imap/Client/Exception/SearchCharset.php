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
 * Exception thrown if search query text cannot be converted to different
 * charset.
 *
 * @category  Horde
 */
class Horde_Imap_Client_Exception_SearchCharset
extends Horde_Imap_Client_Exception
{
    /**
     * Charset that was attempted to be converted to.
     *
     * @var string
     */
    public $charset;

    /**
     * Constructor.
     *
     * @param string $charset  The charset that was attempted to be converted
     *                         to.
     */
    public function __construct($charset)
    {
        $this->charset = $charset;

        parent::__construct(
            Horde_Imap_Client_Translation::r("Cannot convert search query text to new charset"),
            self::BADCHARSET
        );
    }

}
