<?php

namespace mre\Beacon\Exception;

class UnsupportedFormatException extends \Exception
{
    public function __construct($sMessage)
    {
        parent::__construct($sMessage);
    }
}
