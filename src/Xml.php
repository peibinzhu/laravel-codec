<?php

declare(strict_types=1);

namespace PeibinLaravel\Codec;

use Illuminate\Contracts\Support\Arrayable;
use PeibinLaravel\Codec\Contracts\Xmlable;
use PeibinLaravel\Codec\Exception\InvalidArgumentException;
use SimpleXMLElement;

class Xml
{
    public static function toXml(mixed $data, ?SimpleXMLElement $parentNode = null, string $root = 'root')
    {
        if ($data instanceof Xmlable) {
            return (string)$data;
        }
        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        } else {
            $data = (array)$data;
        }
        if ($parentNode === null) {
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?>' . "<{$root}></{$root}>");
        } else {
            $xml = $parentNode;
        }
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                self::toXml($value, $xml->addChild($key));
            } else {
                if (is_numeric($key)) {
                    $xml->addChild('item' . $key, (string)$value);
                } else {
                    $xml->addChild($key, (string)$value);
                }
            }
        }
        return trim($xml->asXML());
    }

    public static function toArray($xml): array
    {
        $respObject = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NOERROR);

        if ($respObject === false) {
            throw new InvalidArgumentException('Syntax error.');
        }

        return json_decode(json_encode($respObject), true);
    }
}
