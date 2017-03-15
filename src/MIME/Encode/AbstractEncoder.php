<?php

namespace Techart\MIME\Encode;


/**
 * Абстрактный класс кодировщика
 *
 * @abstract
 * @package MIME\Encode
 */
abstract class AbstractEncoder implements \Iterator
{

	protected $stream;
	protected $current;
	protected $count = 0;

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
	 * Устанавливает входной поток
	 *
	 * @param \Techart\IO\Stream\AbstractStream $stream
	 *
	 * @return \Techart\MIME\Encode\AbstractEncoder
	 */
	public function from_stream(\Techart\IO\Stream\AbstractStream $stream)
	{
		$this->stream = $stream;
		return $this;
	}

	/**
	 * Возвращает текущий элемент итератора
	 *
	 */
	public function current()
	{
		return $this->current;
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
	 * Проверяет валидность текущего элемента итератора
	 *
	 * @return boolean
	 */
	public function valid()
	{
		return $this->current === null ? false : true;
	}

	/**
	 * Устанавливает выходной поток
	 *
	 * @param \Techart\IO\Stream\AbstractStream $stream
	 *
	 * @return \Techart\MIME\Encode\AbstractEncoder
	 */
	public function to_stream(\Techart\IO\Stream\AbstractStream $stream)
	{
		foreach ($this as $line)
			$stream->write($line);
		return $this;
	}

	/**
	 * Возвращает весь закодированный текст
	 *
	 * @return string
	 */
//TODO: если есть to_string чтобы не добавить Core_StringifyInterface
	public function to_string()
	{
		$result = '';
		foreach ($this as $line)
			$result .= $line;
		return $result;
	}

	/**
	 * Кодирует текст
	 *
	 * @param string $text
	 */
	abstract public function encode($text);

}
