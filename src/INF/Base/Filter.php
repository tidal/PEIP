<?php

namespace PEIP\INF\Base;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Base\Filter.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 */
interface Filter
{
    public function acceptValue($value);
}
