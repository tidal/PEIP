<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Context\ContextPlugin 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage context 
 */



namespace PEIP\INF\Context;

interface ContextPlugin {

    public function init(\PEIP\INF\Context\Context $context);
    
}
