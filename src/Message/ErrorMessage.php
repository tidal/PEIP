<?php

namespace PEIP\Message;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * ErrorMessage.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @extends \PEIP\Message\GenericMessage
 * @implements \PEIP\INF\Base\Buildable, \PEIP\INF\Message\Message, \PEIP\INF\Base\Container
 */
class ErrorMessage extends \PEIP\Message\GenericMessage implements \PEIP\INF\Message\Message
{
    protected $payload;

    protected $headers;

    /**
     * @param $payload
     * @param $headers
     *
     * @return
     */
    public function __construct(\Exception $payload, array $headers = [])
    {
        $this->payload = $payload;
        $this->headers = $headers;
    }
}
