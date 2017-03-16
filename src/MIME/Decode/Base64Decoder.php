<?php

namespace Techart\MIME\Decode;


/**
 * Base64 декодировщик
 *
 * @package MIME\Decode
 */
class Base64Decoder extends AbstractDecoder
{

    protected $buffer = '';

    /**
     * Возвращает следующий элемент итератора
     *
     */
    public function next()
    {
        while (($line = $this->read_line()) !== null) {
            $this->buffer .= \Techart\Core\Regexps::replace('{[^a-zA-Z0-9+/]}', '', $line);
            if (strlen($this->buffer) > \Techart\MIME\Decode::BASE64_CHUNK_SIZE) {
                break;
            }
        }

        if ($this->buffer == '') {
            $this->current = null;
        } else {
            if (strlen($this->buffer) > \Techart\MIME\Decode::BASE64_CHUNK_SIZE) {
                $len_4xN = strlen($this->buffer) & ~3;
                $this->current = base64_decode(substr($this->buffer, 0, $len_4xN));
                $this->buffer = substr($this->buffer, $len_4xN);
            } else {
                $this->buffer .= '===';
                $len_4xN = strlen($this->buffer) & ~3;
                $this->current = base64_decode(substr($this->buffer, 0, $len_4xN));
                $this->buffer = '';
            }
            $this->count++;
        }
    }

}
