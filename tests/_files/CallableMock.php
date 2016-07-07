<?php


class CallableMock
{
    public function repeat($x)
    {
        return $x;
    }

    public static function repeatStatic($x)
    {
        return $x;
    }
}

function callable_mock_function($x)
{
    return $x;
}
