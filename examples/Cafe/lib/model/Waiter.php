<?php


class Waiter
{
    protected $orders;

    public function prepareDelivery(array $drinks)
    {
        echo PEIP_LINE_SEPARATOR.'Waiter: prepareDelivery: #'.$drinks[0]->getOrderNumber();

        return new Delivery($drinks);
    }

    public function receiveOrder(Order $order)
    {
        echo PEIP_LINE_SEPARATOR.'Waiter: receiveOrder';
        $this->orders[$order->getOrderNumber()] = $order;
    }

    public function getOrder($nr)
    {
        return $this->orders[$nr];
    }
}
