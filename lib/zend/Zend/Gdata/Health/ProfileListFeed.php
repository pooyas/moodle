<?php

/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @version    $Id$
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

/**
 * @see Zend_Gdata_Feed
 */
require_once 'Zend/Gdata/Feed.php';

/**
 * Represents a Google Health user's Profile List Feed
 *
 * @link http://code.google.com/apis/health/
 *
 * @category   Zend
 */
class Zend_Gdata_Health_ProfileListFeed extends Zend_Gdata_Feed
{
    /**
     * The class name for individual profile feed elements.
     *
     * @var string
     */
    protected $_entryClassName = 'Zend_Gdata_Health_ProfileListEntry';

    public function getEntries()
    {
        return $this->entry;
    }
}
