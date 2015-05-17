<?php
/**
 * Exception handler for the Horde_Secret library.
 *
 * Copyright 2010-2014 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category Horde
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */
class Horde_Secret_Exception extends Horde_Exception_Wrapped
{
    // Error codes.
    const NO_BLOWFISH_LIB = 0; // 0 for BC
    const KEY_NOT_STRING = 2;
    const KEY_ZERO_LENGTH = 3;
}
