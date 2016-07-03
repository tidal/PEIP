<?php

class Delivery {

    protected 
        $deliveredDrinks,
        $orderNumber;
	
    public function __construct(array $deliveredDrinks) {
        $this->deliveredDrinks = $deliveredDrinks;
        $this->orderNumber = $deliveredDrinks[0]->getOrderNumber();
    }



}