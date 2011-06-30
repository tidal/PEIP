<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestServiceFactory
 *
 * @author timo
 */
class TestServiceFactory extends PEIP\Factory\ServiceFactory{

    public function arg($config){
        return $this->buildArg($config);
    }

    public function modify($service, $config){
        return $this->modifyService($service, $config);
    }


}

