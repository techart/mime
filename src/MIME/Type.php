<?php

namespace Techart\MIME;

class Type implements \Techart\Core\PropertyAccessInterface, \Techart\Core\StringifyInterface
{
    protected $type;
    protected $extensions = array();
    protected $encoding;

    protected $simplified;

    /**
     * Конструктор
     *
     * @param string $type
     * @param string $extensions
     * @param string $encoding
     */
    public function __construct($type, $extensions = null, $encoding = null)
    {
        $this->type = (string)$type;
        $this->simplified = self::simplify($this->type);
        $this->extensions = is_null($extensions) ? array() : (array)$extensions;

        $this->encoding = $encoding ?: ($this->main_type == 'text' ? \Techart\MIME::ENCODING_QP : \Techart\MIME::ENCODING_B64);
    }

    /**
     * Возвращает значение свойства
     *
     * @param string $property
     *
     * @return mixed
     * @throws \Techart\Core\MissingPropertyException
     */
    public function __get($property)
    {
        switch ($property) {
            case 'type':
            case 'extensions':
            case 'encoding':
            case 'simplified':
                return $this->$property;
            case 'name':
                return $this->type;
            case 'media_type':
            case 'main_type':
                return preg_match('{^([\w-]+)/}', $this->simplified, $m) ? $m[1] : null;
            case 'subtype':
                return preg_match('{/([\w-]+)$}', $this->simplified, $m) ? $m[1] : null;
            default:
                throw new \Techart\Core\MissingPropertyException($property);
        }
    }

    /**
     * Устанавливает значение свойства
     *
     * @param string $property
     * @param        $value
     *
     * @return mixed
     * @throws \Techart\Core\ReadOnlyObjectException
     */
    public function __set($property, $value)
    {
        throw new \Techart\Core\ReadOnlyObjectException($this);
    }

    /**
     * Проверяет установку значения свойства
     *
     * @param string $property
     *
     * @return boolean
     */
    public function __isset($property)
    {
        switch ($property) {
            case 'name':
            case 'type':
            case 'extensions':
            case 'encoding':
            case 'simplified':
            case 'media_type':
            case 'main_type':
            case 'subtype':
                return true;
            default:
                return false;
        }
    }

    /**
     * Удаляет свойство объекта
     *
     * @param string $property
     *
     * @throws \Techart\Core\ReadOnlyObjectException
     */
    public function __unset($property)
    {
        throw new \Techart\Core\ReadOnlyObjectException($this);
    }

    /**
     * <p>Возвращает упрощенное имя типа.</p>
     *
     * @param string $type
     *
     * @return string
     */
    public static function simplify($type)
    {
        if (preg_match('{^\s*(?:x\-)?([\w.+-]+)/(?:x\-)?([\w.+-]+)\s*$}', $type, $m)) {
            return strtolower($m[1] . '/' . $m[2]);
        }
        return preg_match('{text}', $type) ? 'text/plain' : null;
    }

    /**
     * Возвращает строковое представление объекта
     *
     * @return string
     */
    public function as_string()
    {
        return $this->type;
    }

    /**
     * Возващает строковое представление объекта
     *
     * @return string
     */
    public function __toString()
    {
        return $this->as_string();
    }
}
