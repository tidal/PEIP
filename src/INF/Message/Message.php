<?php

namespace PEIP\INF\Message;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Message\Message.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @implements \PEIP\INF\Base\Container
 */
interface Message extends \PEIP\INF\Base\Container
{
    public function getHeaders();

    public function getHeader($name);

    public function addHeader($name, $value);
}
