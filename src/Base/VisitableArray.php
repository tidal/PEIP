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
 * VisitableArray.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @extends RecursiveArrayIterator
 * @implements RecursiveIterator, Iterator, Traversable, ArrayAccess, SeekableIterator, Serializable, \PEIP\INF\Base\Visitable
 */
class VisitableArray extends \RecursiveArrayIterator implements \PEIP\INF\Base\Visitable
{
    /**
     * @param $visitor
     *
     * @return
     */
    public function acceptVisitor(\PEIP\INF\Base\Visitor $visitor)
    {
        if ($this->hasChildren()) {
            foreach ($this->getChildren as $child) {
                $child->acceptVisitor($visitor);
            }
        }
        $this->acceptVisitor($visitor);
    }
}
