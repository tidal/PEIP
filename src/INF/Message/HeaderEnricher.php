<?php

namespace PEIP\INF\Message;

namespace PEIP\INF\Message;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Message\HeaderEnricher.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 */
interface HeaderEnricher
{
    /**
     * @param \PEIP\INF\Message\Message $message
     *
     * @return
     */
    public function enrich(\PEIP\INF\Message\Message $message);
}
