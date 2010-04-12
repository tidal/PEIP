<?php

require_once(__DIR__.'/../../misc/bootstrap.php');

$autoloader = PEIP_Autoload::getInstance();
// setting Messaging class paths
$autoloader->setClassPath('CafeGateway', '../examples/Cafe/messaging/CafeGateway.php');
$autoloader->setClassPath('OrderSplitter', '../examples/Cafe/messaging/OrderSplitter.php');
$autoloader->setClassPath('DrinkRouter', '../examples/Cafe/messaging/DrinkRouter.php');
$autoloader->setClassPath('DrinkAggregator', '../examples/Cafe/messaging/DrinkAggregator.php');
// setting Model class paths
$autoloader->setClassPath('Barista', '../examples/Cafe/model/Barista.php');
$autoloader->setClassPath('Cafe', '../examples/Cafe/model/Cafe.php');
$autoloader->setClassPath('Delivery', '../examples/Cafe/model/Delivery.php');
$autoloader->setClassPath('Drink', '../examples/Cafe/model/Drink.php');
$autoloader->setClassPath('DrinkType', '../examples/Cafe/model/DrinkType.php');
$autoloader->setClassPath('Order', '../examples/Cafe/model/Order.php');
$autoloader->setClassPath('Waiter', '../examples/Cafe/model/Waiter.php');