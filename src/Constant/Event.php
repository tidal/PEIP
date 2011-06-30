<?php

namespace PEIP\Constant;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\Constant\Event
 * Wrapper Class for Event Constants
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP
 * @subpackage Constant
 */

class Event {

    const
        CONNECT                 = 'connect',
        DISCONNECT              = 'disconnect',
        SUBSCRIBE               = 'subscribe',
        UNSUBSCRIBE             = 'unsubscribe',
        PRE_SEND                = 'preSend',
        POST_SEND               = 'postSend',
        PRE_RECEIVE             = 'preReceive',
        POST_RECEIVE            = 'postReceive',
        PRE_PUBLISH             = 'prePublish',
        POST_PUBLISH            = 'postPublish',
        PRE_COMMAND             = 'preCommand',
        POST_COMMAND            = 'postCommand',
        SET_DISPATCHER          = 'setEventDispatcher',
        SET_MESSAGE_DISPATCHER  = 'setMessageDispatcher',
        READ_SERVICE            = 'readService',
        READ_CONTEXT            = 'readContext',
        READ_NODE               = 'readNode',
        BEFORE_BUILD_NODE       = 'beforeBuildNode',
        BUILD_NODE_SUCCESS      = 'successBuildNode',
        BUILD_NODE_ERROR        = 'errorBuildNode',
        BEFORE_ADD_CONFIG       = 'beforeAddConfig',
        AFTER_ADD_CONFIG        = 'afterAddConfig',
        BEFORE_PROVIDE_SERVICE  = 'beforeProvideService',
        AFTER_PROVIDE_SERVICE   = 'afterProvideService',
        BEFORE_CREATE_SERVICE   = 'beforeCreateService',
        CREATE_SERVICE_SUCCESS  = 'successCreateService',
        CREATE_SERVICE_ERROR    = 'errorCreateService',
        SET_EVENT_DISPATCHER    = 'setEventDispatcher';

}

