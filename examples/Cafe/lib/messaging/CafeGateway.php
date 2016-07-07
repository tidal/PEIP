<?php

use PEIP\Gateway\SimpleMessagingGateway;

class CafeGateway extends SimpleMessagingGateway
{
    public function placeOrder(Order $order)
    {
        echo "\nCafe: place order #".$order->getOrderNumber();
        $this->send($order);
    }

    public function receiveDelivery()
    {
        return $this->receive();
    }
}
