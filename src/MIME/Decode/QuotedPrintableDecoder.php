<?php

namespace Techart\MIME\Decode;

/**
 * QuotedPrintable декодировщик
 *
 * @package MIME\Decode
 */
class QuotedPrintableDecoder extends AbstractDecoder
{

    /**
     * Возвращает следующий элемент итератора
     *
     */
    public function next()
    {
        $this->current = ($line = $this->read_line()) === null ?
            null : \Techart\MIME::decode_qp($line);
        $this->count++;
    }

}
