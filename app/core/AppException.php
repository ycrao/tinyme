<?php


class AppException extends \Exception
{

    public function __construct($message = null, $code = 500, $previous = null)
    {
        parent::__construct($message, $code, $previous = null);
    }
}