<?php

namespace Techart\MIME\Encode;

/**
 * EightBit кодировщик
 *
 * @package MIME\Encode
 */
class EightBitEncoder extends AbstractEncoder
{

	/**
	 * Сбрасывает итератор на начало
	 *
	 */
	public function rewind()
	{
		$this->count = 0;
		$this->current = $this->stream->read_line();
	}

	/**
	 * Возвращает следующий элемент итератора
	 *
	 */
	public function next()
	{
		if (($this->current = $this->stream->read_line()) !== null) {
			$this->count++;
		}
	}

	/**
	 * Кодирует текст
	 *
	 * @param string $text
	 */
	public function encode($text)
	{
		return $text;
	}

}

