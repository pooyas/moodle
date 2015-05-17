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
 * An object representing an IMAP tagged response (RFC 3501 [2.2.2]).
 *
 * @category  Horde
 */
class Horde_Imap_Client_Interaction_Server_Tagged
extends Horde_Imap_Client_Interaction_Server
{
    /**
     * Tag.
     *
     * @var string
     */
    public $tag;

    /**
     * @param string $tag  Response tag.
     */
    public function __construct(Horde_Imap_Client_Tokenize $token, $tag)
    {
        $this->tag = $tag;

        parent::__construct($token);

        if (is_null($this->status)) {
            throw new Horde_Imap_Client_Exception(
                Horde_Imap_Client_Translation::r("Bad tagged response.")
            );
        }
    }

}
