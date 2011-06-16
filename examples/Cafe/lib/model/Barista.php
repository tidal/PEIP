<?php


class Barista {

    private $hotDrinkDelay = 0;
    private $coldDrinkDelay = 0;
    private $hotDrinkCounter = 0;
    private $coldDrinkCounter = 0;

    public function setHotDrinkDelay($hotDrinkDelay) {
        $this->hotDrinkDelay = (int)$hotDrinkDelay;
    }

    public function setColdDrinkDelay($coldDrinkDelay) {
        $this->coldDrinkDelay = (int)$coldDrinkDelay;
    }

    public function prepareHotDrink(array $orderItem) {
        sleep($this->hotDrinkDelay);
        $this->hotDrinkCounter++;
        $this->printAction(false, $orderItem['order']);
        return $this->prepareDrink($orderItem['order'], $orderItem['type'], false);
    }

    public function prepareColdDrink(array $orderItem) {
        sleep($this->coldDrinkDelay);
        $this->coldDrinkCounter++;
        $this->printAction(true, $orderItem['order']);
        return $this->prepareDrink($orderItem['order'], $orderItem['type'], true);
    }    
	
    protected function prepareDrink($orderNumber, $type, $iced){
    	$drink = new Drink($orderNumber, $type, $iced);	
    	return $drink;
    }

    protected function printAction($cold, $orderNr){
    	if($cold){
    		$type = 'cold';
    		$count = $this->coldDrinkCounter;
    	}else{
    		$type = 'hot';
    		$count = $this->hotDrinkCounter;    		
    	}
    	$total = $this->coldDrinkCounter + $this->hotDrinkCounter;
        echo PEIP_LINE_SEPARATOR."Barista: prepared $type drink (total #$total- $type #$count) for order #$orderNr";
        flush();    
    }
    
}
