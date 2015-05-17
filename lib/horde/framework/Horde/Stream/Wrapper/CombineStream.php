<?php
/**
 * Copyright 2009-2014 Horde LLC (http://www.horde.org/)
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
 * Provides access to the CombineStream stream wrapper.
 *
 * @category   Horde
 * @deprecated Use Horde_Stream_Wrapper_Combine::getStream()
 */
interface Horde_Stream_Wrapper_CombineStream
{
    /**
     * Return a reference to the data.
     *
     * @return array
     */
    public function getData();
}

