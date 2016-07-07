<?php

// please, change "<br>" to "\n" in the follwing line, when you run this file in the CLI
define('PEIP_LINE_SEPARATOR', "\n");

// This is PEIP�s (basic) way of the famous starbucks example from
// Gregor Hohpe http://www.eaipatterns.com/ramblings/18_starbucks.html

// Note since this example works in a single threaded environment it
// processes the orders in a synchronous way - every order is placed,
// prepared and delivered one after the other.
// How to avoid this behavior will be shown in further examples.


// requiring autoloader
require_once dirname(__FILE__).'/misc/bootstrap.php';


$context = PEIP\Context\XMLContext::createFromFile(dirname(__FILE__).'/config/config.xml');
$cafe = $context->getGateway('CafeGateway');

// this would be the same done by scripting.
/* ==
 * $registry = new PEIP_Channel_Registry;
 * $orders = new PEIP_Publish_Subscribe_Channel('orders');
 * $preparedDrinks = new PEIP_Publish_Subscribe_Channel('preparedDrinks');
 * $coldDrinks = new PEIP_Pollable_Channel('coldDrinks');
 * $registry->register($coldDrinks);
 * $hotDrinks = new PEIP_Pollable_Channel('hotDrinks');
 * $registry->register($hotDrinks);
 * $deliveries = new PEIP_Pollable_Channel('deliveries');
 * $cafeGateway = new CafeGateway($orders, $deliveries);
 * $orderWiretap = PEIP_Wiretap($orders);
 * $orderSplitter = new OrderSplitter($orders);
 * $router = new DrinkRouter($orderSplitter);
 * $barista = new Barista;
 * $coldDrinksActivator = new PEIP_Service_Activator(array($barista, 'prepareColdDrink'), $coldDrinks, $preparedDrinks);
 * $hotDrinksActivator = new PEIP_Service_Activator(array($barista, 'prepareHotDrink'), $hotDrinks, $preparedDrinks);
 * $drinkAggregator = new DrinkAggregator($preparedDrinks);
 * $aggregatorActivator = new PEIP_Service_Activator(array($drinkAggregator, 'receiveOrder'), $orderWiretap);
 * $waiter = new Waiter;
 * $waiterActivator = new PEIP_Service_Activator(array($waiter, 'prepareDelivery'), $drinkAggregator, $deliveries);
 * $cafe = $cafeGateway;
 */


if ($cafe) {
    for ($i = 1; $i <= 10; $i++) {
        // create and place orders
        $order = new Order();
        $order->addItem('LATTE', 2, false);
        $order->addItem('MOCCA', 3, true);
        $cafe->placeOrder($order);
            // receive drinks
        $drinks = $cafe->receiveDelivery();
    }
} else {
    throw new RuntimeException('Could not get CafeGateway');
}
