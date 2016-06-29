<?php

require_once(dirname(__FILE__).'/../../../misc/bootstrap.php');

foreach (glob(realpath(dirname(__FILE__)."/../lib/model/")."/*.php") as $filename){
    require_once $filename;
}

foreach (glob(realpath(dirname(__FILE__)."/../lib/messaging/")."/*.php") as $filename){
    require_once $filename;
}

