<?php

namespace StrehleDe\XmlToCypher\Import;


class GraphXmlParameter
{
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_FLOAT = 'float';
    const TYPE_INTEGER = 'integer';
    const TYPE_NULL = 'null';
    const TYPE_STRING = 'string';


    /**
     * @param string $name
     * @param string|string[] $strValue
     * @param string $type
     */
    public function __construct(
        protected string $name,
        protected string|array $strValue,
        protected string $type = self::TYPE_STRING
    )
    {
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @return bool|float|int|null|string|array
     */
    public function getValue(): bool|float|int|null|string|array
    {
        if (!is_array($this->strValue)) {
            return self::stringToTypedValue($this->strValue, $this->type);
        }

        $value = [];

        foreach ($this->strValue as $strVal) {
            $value[] = self::stringToTypedValue($strVal, $this->type);
        }

        return $value;
    }


    /**
     * @param string $value
     * @param string $type
     * @return bool|float|int|null|string
     */
    protected static function stringToTypedValue(string $value, string $type): bool|float|int|null|string
    {
        // Names of types taken from https://github.com/neo4j-php/neo4j-php-client#accessing-the-results

        return match (strtolower($type)) {
            self::TYPE_BOOLEAN => boolval($value),
            self::TYPE_FLOAT => floatval($value),
            self::TYPE_INTEGER => intval($value),
            self::TYPE_NULL => null,
            default => $value
        };
    }
}