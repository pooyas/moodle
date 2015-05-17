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
 * Implementation of Horde_Stream for an existing stream resource. This
 * resource will be directly modified when manipulating using this class.
 *
 *
 * @category  Horde
 */
class Horde_Stream_Existing extends Horde_Stream
{
    /**
     * Constructor.
     *
     * @param array $opts  Additional configuration options:
     *   - stream: (resource) [REQUIRED] The stream resource.
     *
     * @throws Horde_Stream_Exception
     */
    public function __construct(array $opts = array())
    {
        if (!isset($opts['stream']) || !is_resource($opts['stream'])) {
            throw new Horde_Stream_Exception('Need a stream resource.');
        }

        $this->stream = $opts['stream'];
        unset($opts['stream']);

        parent::__construct($opts);
    }

}
