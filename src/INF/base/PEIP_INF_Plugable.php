<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Connectable
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP
 * @subpackage event
 */


interface PEIP_INF_Plugable {

    public function connect($listener);

    public function disconnect($listener);

    public function disconnectAll();

    public function hasListeners();

    public function getListeners();
}

