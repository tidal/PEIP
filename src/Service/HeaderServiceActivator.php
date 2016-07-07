<?php

namespace PEIP\Service;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HeaderServiceActivator.
 *
 * @author timo
 */
class HeaderServiceActivator extends \PEIP\Service\ServiceActivator
{
    protected $headerName;

    /**
     * @param $serviceCallable
     * @param $inputChannel
     * @param $outputChannel
     *
     * @return
     */
    public function __construct($serviceCallable, $headerName, \PEIP\INF\Channel\Channel $inputChannel = null, \PEIP\INF\Channel\Channel $outputChannel = null)
    {
        $this->headerName = $headerName;
        parent::__construct($serviceCallable, $inputChannel, $outputChannel);
    }

    /**
     * Calls a method on a service (registered as a callable) with
     * content/payload of given message as argument.
     *
     * @param \PEIP\INF\Message\Message $message message to call the service with it�s content/payload
     *
     * @return mixed result of calling the registered service callable with message content/payload
     */
    protected function callService(\PEIP\INF\Message\Message $message)
    {
        $res = null;
        if (is_callable($this->serviceCallable)) {
            $res = call_user_func($this->serviceCallable, $message->getHeader($this->headerName));
        } else {
            if (is_object($this->serviceCallable) && method_exists($this->serviceCallable, 'handle')) {
                $res = $this->serviceCallable->handle($message->getHeader($this->headerName));
            }
        }

        return $res;
    }
}
