<?php

namespace PEIP\Message;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * TextMessage
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP
 * @subpackage message
 * @extends \PEIP\Message\StringMessage
 * @implements \PEIP\INF\Base\Container, \PEIP\INF\Message\Message, \PEIP\INF\Base\Buildable
 */


use PEIP\Base\GenericBuilder;

class TextMessage extends \PEIP\Message\StringMessage
{
    protected $title;

    /**
     * @param $content
     * @param $title
     *
     * @return
     */
    public function __construct($content, $title)
    {
        $this->setContent((string) $content);
    }

    /**
     * @param $title
     *
     * @return
     */
    public function setTitle($title)
    {
        $this->title = (string) $title;
    }

    /**
     * @return
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Provides a static build method to create new Instances of this class.
     * Implements \PEIP\INF\Base\Buildable. Overwrites GenericMessage::build.
     *
     * @static
     * @implements \PEIP\INF\Base\Buildable
     *
     * @return bool wether the header is set
     */
    public static function build(array $arguments = [])
    {
        return GenericBuilder::getInstance('\PEIP\Message\StringMessage')->build($arguments);
    }
}
