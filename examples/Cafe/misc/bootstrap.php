<?php

require_once(__DIR__.'/../../misc/bootstrap.php');

$autoloader = PEIP_Autoload::getInstance();
$autoloader->scanDirectory(__DIR__.'/../lib/');
