<?php
/**
 * Stream filter class to convert binary data into hexadecimal.
 *
 * Usage:
 *   stream_filter_register('horde_bin2hex', 'Horde_Stream_Filter_Bin2hex');
 *   stream_filter_[app|pre]pend($stream, 'horde_bin2hex',
 *                               [ STREAM_FILTER_[READ|WRITE|ALL] ]);
 *
 * Copyright 2011-2014 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category Horde
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */
class Horde_Stream_Filter_Bin2hex extends php_user_filter
{
    /**
     * @see stream_filter_register()
     */
    public function filter($in, $out, &$consumed, $closing)
    {
        while ($bucket = stream_bucket_make_writeable($in)) {
            $bucket->data = bin2hex($bucket->data);
            $consumed += $bucket->datalen;
            stream_bucket_append($out, $bucket);
        }

        return PSFS_PASS_ON;
    }

}
