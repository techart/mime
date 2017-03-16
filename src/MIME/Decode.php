<?php

namespace Techart\MIME;

class Decode
{
    const BASE64_CHUNK_SIZE = 32768;
    /** @noinspection PhpUndefinedClassInspection */

    /**
     * Возвращает декодировщик соответствующий $encoding
     *
     * @param string $encoding
     * @param \Techart\IO\Stream\AbstractStream $stream
     *
     * @return IO_Stream_AbstractDecoder
     */
    static public function decoder($encoding, \Techart\IO\Stream\AbstractStream $stream = null)
    {
        switch ($encoding) {
            case \Techart\MIME::ENCODING_B64:
                return new \Techart\MIME\Decode\Base64Decoder($stream);
            case \Techart\MIME::ENCODING_QP:
                return new \Techart\MIME\Decode\QuotedPrintableDecoder($stream);
            case \Techart\MIME::ENCODING_8BIT:
            default:
                return new \Techart\MIME\Decode\EightBitDecoder($stream);
        }
    }

    /**
     * Фабричный метод, возвращает объект класса MIME.Decode.Base64Decoder
     *
     * @param \Techart\IO\Stream\AbstractStream $stream
     *
     * @return \Techart\MIME\Decode\Base64Decoder
     */
    static public function Base64Decoder(\Techart\IO\Stream\AbstractStream $stream = null)
    {
        return new \Techart\MIME\Decode\Base64Decoder($stream);
    }

    /**
     * Фабричный метод, возвращает объект класса MIME.Decode.QuoterPrintableDecoder
     *
     * @param \Techart\IO\Stream\AbstractStream $stream
     *
     * @return \Techart\MIME\Decode\QuotedPrintableDecoder
     */
    static public function QuotedPrintableDecoder(\Techart\IO\Stream\AbstractStream $stream = null)
    {
        return new \Techart\MIME\Decode\QuotedPrintableDecoder($stream);
    }

}
