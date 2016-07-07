<?php

namespace PEIP\Base;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * DynamicAdapter.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 */
class DynamicAdapter
{
    protected $methodMap;

    protected $subject;

    /**
     * @param $methodMap
     * @param $subject
     *
     * @return
     */
    public function __construct(\ArrayAccess $methodMap, $subject)
    {
        $this->methodMap = $methodMap;
        $this->subject = $subject;
    }

    /**
     * @param $method
     * @param $arguments
     *
     * @return
     */
    public function __call($method, array $arguments)
    {
        if (array_key_exists($method, $this->methodMap)) {
            return call_user_func_array([$this->subject, $this->methodMap[$method]], $arguments);
        }
    }
}
