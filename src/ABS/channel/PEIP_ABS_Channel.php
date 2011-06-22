<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * PEIP_ABS_Channel 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 * @implements PEIP_INF_Channel, PEIP_INF_Connectable
 */

abstract class PEIP_ABS_Channel
    extends PEIP_ABS_Connectable

    implements
        PEIP_INF_Channel,
        PEIP_INF_Connectable {

    protected
        $name;

    /**
     * @access public
     * @param $name
     * @return
     */
    public function __construct($name){
        $this->name = $name;
    }

    /**
     * @access public
     * @return string the channel�s name
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @access public
     * @param PEIP_INF_Message $message
     * @param integer $timeout
     * @return
     */
    public function send(PEIP_INF_Message $message, $timeout = -1){
        $this->doFireEvent('preSend', array('MESSAGE'=>$message));
        $sent = $this->doSend($message);
        $this->doFireEvent('postSend', array(
            'MESSAGE'=>$message,
            'SENT' => $sent,
            'TIMEOUT' => $timeout
        ));
    }


    /**
     * @access protected
     * @param PEIP_INF_Message $message
     * @return
     */
    abstract protected function doSend(PEIP_INF_Message $message);

}