<?php

namespace PEIP\INF\Dispatcher;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Dispatcher\Dispatcher.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 */
interface Dispatcher
{
    public function notify($subject);
}
