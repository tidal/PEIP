<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Visitable_Array 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage base 
 * @extends RecursiveArrayIterator
 * @implements RecursiveIterator, Iterator, Traversable, ArrayAccess, SeekableIterator, Serializable, PEIP_INF_Visitable
 */


class PEIP_Visitable_Array extends RecursiveArrayIterator implements PEIP_INF_Visitable{


    
    /**
     * @access public
     * @param $visitor 
     * @return 
     */
    public function acceptVisitor(PEIP_INF_Visitor $visitor){
        if($this->hasChildren()){
            foreach($this->getChildren as $child){
                $child->acceptVisitor($visitor);
            }
        }
        $this->acceptVisitor($visitor);
    }
}


