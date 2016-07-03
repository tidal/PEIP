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
 * \PEIP\INF\Dispatcher\ListDispatcher 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage dispatcher 
 * @implements \PEIP\INF\Dispatcher\Dispatcher
 */




interface ListDispatcher extends \PEIP\INF\Dispatcher\Dispatcher {

    public function connect( $handler);

    public function disconnect( $handler);

    public function hasListeners();

    public function getListeners();

}