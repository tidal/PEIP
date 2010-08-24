<?php

require_once(dirname(__FILE__).'/../../../misc/bootstrap.php');

$autoloader = PEIP_Autoload::getInstance();
$autoloader->scanDirectory(dirname(__FILE__).'/../lib/');
