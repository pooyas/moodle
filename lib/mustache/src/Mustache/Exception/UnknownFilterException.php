<?php

/*
 * This file is part of Mustache.php.
 *
 * (c) 2010-2014 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Unknown filter exception.
 */
class Mustache_Exception_UnknownFilterException extends UnexpectedValueException implements Mustache_Exception
{
    protected $filterName;

    /**
     * @param string $filterName
     */
    public function __construct($filterName)
    {
        $this->filterName = $filterName;
        parent::__construct(sprintf('Unknown filter: %s', $filterName));
    }

    public function getFilterName()
    {
        return $this->filterName;
    }
}
