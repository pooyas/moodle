<?php
/**
 * Copyright 2007-2014 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (BSD). If you
 * did not receive this file, see http://www.horde.org/licenses/bsd.
 *
 * @category  Horde
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Provides access to the StringStream stream wrapper.
 *
 * @category   Horde
 * @deprecated Use Horde_Stream_Wrapper_String::getStream()
 */
interface Horde_Stream_Wrapper_StringStream
{
    /**
     * Return a reference to the wrapped string.
     *
     * @return string
     */
    public function &getString();
}
