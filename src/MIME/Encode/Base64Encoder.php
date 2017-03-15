<?php

namespace Techart\MIME\Encode;

/**
 * Base64 кодировщик
 *
 * @package MIME\Encode
 */
class Base64Encoder extends AbstractEncoder
{

	protected $cache;
	protected $data;
	protected $pos;

	/**
	 * сбрасывает итератор на начало
	 *
	 */
	public function rewind()
	{
		$this->count = 0;
		$this->cache = '';
		$this->pos = 0;

		if (($this->data = $this->stream->read_chunk()) != null) {
			$this->current = base64_encode(
					substr($this->data, 0, \Techart\MIME\Encode::BASE64_CHUNK_SIZE)
				) . \Techart\MIME::LINE_END;
			$this->pos = \Techart\MIME\Encode::BASE64_CHUNK_SIZE;
		}
	}

	/**
	 * Возвращает следующий элемент итератора
	 *
	 */
	public function next()
	{
		while (true) {
			if ($this->data == '' && $this->cache == '') {
				$this->current = null;
				break;
			}

			if ($this->pos + \Techart\MIME\Encode::BASE64_CHUNK_SIZE < strlen($this->data)) {
				$this->current = base64_encode(
						substr($this->data, $this->pos, \Techart\MIME\Encode::BASE64_CHUNK_SIZE)
					) . "\n";
				$this->pos += \Techart\MIME\Encode::BASE64_CHUNK_SIZE;
				$this->count++;
				break;
			} else {
				$this->cache = substr($this->data, $this->pos);

				if (($chunk = $this->stream->read_chunk()) != '') {
					$this->pos = 0;
					$this->data = $this->cache . $chunk;
				} else {
					$this->current = base64_encode($this->cache) . "\n";
					$this->data = '';
					$this->cache = '';
					$this->pos = 0;
					$this->count++;
					break;
				}
			}
		}
	}

	/**
	 * Кодирует текст
	 *
	 * @param string $text
	 */
	public function encode($text)
	{
		return \Techart\MIME::encode_b64($text);
	}

}
