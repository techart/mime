<?php

namespace Techart\MIME\Encode;

/**
 * QuotedPrintable кодировщик
 *
 * @package MIME\Encode
 */
class QuotedPrintableEncoder extends AbstractEncoder
{

	protected $current;
	protected $count = 0;
	protected $length = \Techart\MIME::LINE_LENGTH;

	/**
	 * Сбрасывает итератор в начало
	 *
	 */
	public function rewind()
	{
		$this->count = 0;
		$this->current = \Techart\MIME::encode_qp($this->stream->read_line(), $this->length);
	}

	/**
	 * Возвращает следующий элемент итератора
	 *
	 */
	public function next()
	{
		if ($this->stream->eof()) {
			$this->current = null;
		} else {
			$this->current = \Techart\MIME::encode_qp($this->stream->read_line(), $this->length);
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
		return \Techart\MIME::encode_qp($text, $this->length);
	}

	/**
	 * Устанавливает длину строки кодирования
	 *
	 * @param int $value
	 *
	 * @return \Techart\MIME\Decode\Base64Decoder
	 */
	public function line_length($value)
	{
		$this->length = (int)$value;
		return $this;
	}

}
