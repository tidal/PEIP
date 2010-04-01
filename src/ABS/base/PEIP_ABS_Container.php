<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Container 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage base 
 * @implements PEIP_INF_Container
 */

abstract class PEIP_ABS_Container 
    implements PEIP_INF_Container{

    protected $content;
       
    /**
     * @access public
     * @return 
     */
    public function getContent(){
        return $this->content;
    }

} 
