<?php

namespace ItsPixStore\Exception;

class Exception extends \Exception
{
    public static function create($message, $code = 0, Exception $previous = null) : Exception
    {
        return new static($message, $code, $previous);
    }
}