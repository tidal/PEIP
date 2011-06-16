<?php

require_once(dirname(__FILE__).'/../../../misc/bootstrap.php');
echo "\nAUTOLOAD +++.".realpath(dirname(__FILE__).'/../lib/');
$autoloader = PEIP_Autoload::getInstance();
$autoloader->scanDirectory(realpath(dirname(__FILE__).'/../lib/'));
