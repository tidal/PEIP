<?php

require_once(__DIR__.'/../../misc/bootstrap.php');

$eol = php_sapi_name() == 'cli' ? "\n" : "<br>";
define('EOL', $eol);

function convert($size)
 {
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
 }

 function memory_usage($realUsage = false){
     return convert(memory_get_usage($realUsage));
 }
