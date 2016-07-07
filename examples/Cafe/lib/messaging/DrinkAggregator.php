<?php

use PEIP\INF\Channel\Channel;
use PEIP\INF\Message\Message;

class DrinkAggregator extends \PEIP\Pipe\Pipe
{
    protected $orders = [];
    protected $preparedDrinks = [];

    public function __construct(Channel $inputChannel, Channel $outputChannel = null)
    {
        $this->setInputChannel($inputChannel);
        if (is_object($outputChannel)) {
            $this->setOutputChannel($outputChannel);
        }
        $this->registerCommand('ADD_ORDER', [$this, 'receiveOrder']);
    }

    protected function doReply(Message $message)
    {
        $drink = $message->getContent();
        $nr = $drink->getOrderNumber();
        if (!isset($this->preparedDrinks[$nr])) {
            $this->preparedDrinks[$nr] = [];
        }
        $this->preparedDrinks[$drink->getOrderNumber()][] = $drink;
        if (isset($this->orders[$nr])
            && $this->orders[$nr]->getTotalCount() == count($this->preparedDrinks[$nr])) {
            $this->replyMessage($this->preparedDrinks[$nr]);
            unset($this->preparedDrinks[$nr]);
            echo PEIP_LINE_SEPARATOR.'DrinkAggregator : reply #'.$nr;
        }
    }

    public function receiveOrder(Order $order)
    {
        echo PEIP_LINE_SEPARATOR.'DrinkAggregator: received Order';
        $this->orders[$order->getOrderNumber()] = $order;
    }
}
