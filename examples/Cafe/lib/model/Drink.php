<?php


class Drink
{
    protected $orderNumber,
        $type,
        $iced;

    public function __construct($orderNumber, $type, $iced)
    {
        $this->orderNumber = $orderNumber;
        $this->type = $type;
        $this->iced = $iced;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getIced()
    {
        return $this->iced;
    }

    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    public function __sleep()
    {
        return ['orderNumber', 'type', 'iced'];
    }
}
