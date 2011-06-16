<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PEIP_Header_Service_Activator
 *
 * @author timo
 */
class PEIP_Header_Service_Activator extends PEIP_Service_Activator{
   
    protected $headerName;


    /**
     * @access public
     * @param $serviceCallable
     * @param $inputChannel
     * @param $outputChannel
     * @return
     */
    public function __construct($serviceCallable, $headerName, PEIP_INF_Channel $inputChannel = NULL, PEIP_INF_Channel $outputChannel = NULL){
        $this->headerName = $headerName;
        parent::__construct($serviceCallable, $inputChannel, $outputChannel);
    }


        /**
     * Calls a method on a service (registered as a callable) with
     * content/payload of given message as argument.
     *
     * @access protected
     * @param PEIP_INF_Message $message message to call the service with it�s content/payload
     * @return mixed result of calling the registered service callable with message content/payload
     */
    protected function callService(PEIP_INF_Message $message){
		$res = NULL; 
    	if(is_callable($this->serviceCallable)){
            $res = call_user_func($this->serviceCallable, $message->getHeader($this->headerName));
        }else{
            if(is_object($this->serviceCallable) && method_exists($this->serviceCallable, 'handle')){
                $res = $this->serviceCallable->handle($message->getHeader($this->headerName));
            }
        }
    	return $res;
    }
}

