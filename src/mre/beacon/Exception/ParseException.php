<?php

namespace mre\Beacon\Exception;


class ParseException extends \ErrorException
{

    public function __construct(array $aError)
    {
        $_sMessage   = $aError['message'];
        $_iCode      = isset($aError['code']) ? $aError['code'] : 0;
        $_iSeverity  = isset($aError['type']) ? $aError['type'] : 1;
        $_sFilename  = isset($aError['file']) ? $aError['file'] : __FILE__;
        $_iLineNo    = isset($aError['line']) ? $aError['line'] : __LINE__;
        $_oException = isset($aError['exception']) ? $aError['exception'] : null;

        parent::__construct($_sMessage, $_iCode, $_iSeverity, $_sFilename, $_iLineNo, $_oException);
    }
}
