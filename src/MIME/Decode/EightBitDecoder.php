<?php

namespace Techart\MIME\Decode;

/**
 * EightBit декодировщик
 *
 * @package MIME\Decode
 */
class EightBitDecoder extends AbstractDecoder
{
	/**
	 * Возвращает следующий элемент итератора
	 *
	 */
	public function next()
	{
		if (($this->current = $this->read_line()) !== null) {
			$this->count++;
		}
	}
}

