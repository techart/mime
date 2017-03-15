<?php

namespace Techart\MIME;

class Encode
{
	const BASE64_CHUNK_SIZE = 57;

	/**
	 * Возвращает кодировщик соответствующий $encoding
	 *
	 * @param string                   $encoding
	 * @param \Techart\IO\Stream\AbstractStream $stream
	 *
	 * @return \Techart\MIME\Encode\AbstractEncoder
	 */
	static public function encoder($encoding, \Techart\IO\Stream\AbstractStream $stream = null)
	{
		switch ($encoding) {
			case \Techart\MIME::ENCODING_B64:
				return new \Techart\MIME\Encode\Base64Encoder($stream);
			case \Techart\MIME::ENCODING_QP:
				return new \Techart\MIME\Decode\Base64Decoder($stream);
			case \Techart\MIME::ENCODING_8BIT:
			default:
				return new \Techart\MIME\Encode\EightBitEncoder($stream);
		}
	}

	/**
	 * Фабричный метод, возвращает объект класса MIME.Encode.Base64Encoder
	 *
	 * @param \Techart\IO\Stream\AbstractStream $stream
	 *
	 * @return \Techart\MIME\Encode\Base64Encoder
	 */
	static public function Base64Encoder(\Techart\IO\Stream\AbstractStream $stream = null)
	{
		return new \Techart\MIME\Encode\Base64Encoder($stream);
	}

	/**
	 * Фабричный метод, возвращает объект класса MIME.Encode.QuotePrintableEncoder
	 *
	 * @param \Techart\IO\Stream\AbstractStream $stream
	 *
	 * @return \Techart\MIME\Encode\QuotedPrintableEncoder
	 */
	static public function QuotedPrintableEncoder(\Techart\IO\Stream\AbstractStream $stream = null)
	{
		return new \Techart\MIME\Decode\Base64Decoder($stream);
	}

	/**
	 * Фабричный метод, возвращает объект класса MIME.Encode.EightBitEncoder
	 *
	 * @param \Techart\IO\Stream\AbstractStream $stream
	 *
	 * @return \Techart\MIME\Encode\EightBitEncoder
	 */
	static public function EightBitEncoder(\Techart\IO\Stream\AbstractStream $stream = null)
	{
		return new \Techart\MIME\Encode\EightBitEncoder($stream);
	}

}
