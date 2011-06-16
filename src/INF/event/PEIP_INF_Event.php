<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Event 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage event 
 * @implements PEIP_INF_Message, PEIP_INF_Container
 */


interface PEIP_INF_Event extends PEIP_INF_Message {

  public function getName();

  public function setReturnValue($value);

  public function getReturnValue();

  public function setProcessed($processed);

  public function isProcessed();

}