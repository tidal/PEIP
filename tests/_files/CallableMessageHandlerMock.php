<?php

class CallableMessageHandlerMock
{
    public function reply($message)
    {
        return $message;
    }

    public static function replyStatic($message)
    {
        return $message;
    }

    public static function throwException()
    {
        throw new Exception('Mock Exception');
    }
}
