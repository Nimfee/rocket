<?php

namespace Rocket\APIBundle\Exception;

class APIException extends \Exception
{
    public static function wrongValue($message)
    {
        throw new self($message, APIError::WRONG_VALUE);
    }
}