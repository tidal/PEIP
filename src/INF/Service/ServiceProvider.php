<?php

namespace PEIP\INF\Service;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Service\ServiceProvider
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP
 * @subpackage service
 */

interface ServiceProvider {

    /**
     * returns all registered services
     *
     * @access public
     * @return array registered services
     */
    public function getServices();

    /**
     * returns a service-object for given key
     *
     * @access public
     * @param string $id
     * @return object the requested service
     */

    public function provideService($id);

}

