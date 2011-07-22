<?php

namespace PEIP\INF\Queue;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Queue\Queue
 * Description of Queue
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP
 */

interface Queue {

    public function enqueue($value);

    public function dequeue();
}
