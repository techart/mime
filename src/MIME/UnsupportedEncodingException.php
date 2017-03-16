<?php

namespace Techart\MIME;

class UnsupportedEncodingException extends Exception
{
    protected $encoding;

    public function __construct($encoding)
    {
        $this->encoding = $encoding;
        parent::__construct("Unsupported encoding: $encoding");
    }
}
