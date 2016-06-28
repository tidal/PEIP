<?php

namespace PEIP\ABS\Base;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\ABS\Base\MutableContainer 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage base 
 * @extends \PEIP\ABS\Base\Container
 * @implements \PEIP\INF\Base\Container, \PEIP\INF\Base\MutableContainer
 */




abstract class MutableContainer 
    extends \PEIP\ABS\Base\Container 
    implements \PEIP\INF\Base\MutableContainer {

    
    /**
     * @access public
     * @return mixed content
     */
    public function getContent(){
        return parent::getContent();
    } 
}