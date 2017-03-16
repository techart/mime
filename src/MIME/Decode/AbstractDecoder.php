<?php

namespace Techart\MIME\Decode;

/**
 * Абстрактный класс декодировщика
 *
 * @abstract
 * @package MIME\Decode
 */
abstract class AbstractDecoder implements \Iterator
{

    protected $stream;

    protected $boundary;

    protected $count = 0;
    protected $current;

    protected $is_last_part = false;

    /**
     * Конструктор
     *
     * @param \Techart\IO\Stream\AbstractStream $input
     */
    public function __construct(\Techart\IO\Stream\AbstractStream $stream = null)
    {
        if ($stream) {
            $this->from_stream($stream);
        }
    }

    /**
     * Устанавливает границу
     *
     * @return \Techart\MIME\Decode\AbstractDecoder
     */
    public function with_boundary($boundary)
    {
        $this->boundary = (string)$boundary;
        return $this;
    }

    /**
     * Устанавливает входной поток
     *
     * @param \Techart\IO\Stream\AbstractStream $stream
     *
     * @return \Techart\MIME\Decode\AbstractDecoder
     */
    public function from_stream(\Techart\IO\Stream\AbstractStream $stream)
    {
        $this->stream = $stream;
        return $this;
    }

    /**
     * Проверяет евляется ли текущая часть письма последней
     *
     * @return boolean
     */
    public function is_last_part()
    {
        return $this->is_last_part;
    }

    /**
     * сбрасывает итератор на начало
     *
     */
    public function rewind()
    {
        $this->is_last_part = false;
        $this->count = 0;
        $this->next();
    }

    /**
     * Возвращает текущий элемент итератора
     *
     * @return string
     */
    public function current()
    {
        return $this->current;
    }

    /**
     * Проверяет валидность текущего элемента итератора
     *
     * @return boolean
     */
    public function valid()
    {
        return $this->current !== null;
    }

    /**
     * Возвращает ключ текущего элемента итератора
     *
     * @return int
     */
    public function key()
    {
        return $this->count;
    }

    /**
     * Устанавливает выходной поток
     *
     * @param \Techart\IO\Stream\AbstractStream $stream
     *
     * @return \Techart\MIME\Decode\AbstractDecoder
     */
    public function to_stream(\Techart\IO\Stream\AbstractStream $stream)
    {
        foreach ($this as $chunk)
            $stream->write($chunk);
        return $this;
    }

    /**
     * Устанавливает выходной поток во временный фаил
     *
     * @return \Techart\IO\Stream\TemporaryStream
     */
    public function to_temporary_stream()
    {
        $this->to_stream($stream = \Techart\IO\Stream::TemporaryStream());
        return $stream;
    }

    /**
     * Возвращает весь разкодированный текст
     *
     * @return string
     */
//TODO: если есть to_string чтобы не добавить Core_StringifyInterface
    public function to_string()
    {
        $result = '';
        foreach ($this as $chunk)
            $result .= $chunk;
        return $result;
    }

    /**
     * Проверяет является ли $lien границей письма
     *
     * @param string $line
     *
     * @return boolean
     */
    protected function is_boundary($line)
    {
        return ($this->boundary && \Techart\Core\Regexps::match("{^--{$this->boundary}(?:--)?\n\r?$}", $line));
    }

    /**
     * Считывает строку из входного потока
     *
     * @return string
     */
    protected function read_line()
    {
        if ($this->stream->eof()) {
            $this->is_last_part = true;
            return null;
        }

        $line = $this->stream->read_line();

        if ($this->is_boundary($line)) {
            if (\Techart\Core\Regexps::match("{{$this->boundary}--\n\r?}", $line)) {
                $this->is_last_part = true;
            }
            return null;
        }
        return $line;
    }

}
