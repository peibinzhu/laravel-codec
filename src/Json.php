<?php

declare(strict_types=1);

namespace PeibinLaravel\Codec;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use PeibinLaravel\Codec\Exception\InvalidArgumentException;
use Throwable;

class Json
{
    /**
     * @throws InvalidArgumentException
     */
    public static function encode(mixed $data, int $flags = JSON_UNESCAPED_UNICODE, int $depth = 512): string
    {
        if ($data instanceof Jsonable) {
            return (string)$data;
        }

        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }

        try {
            $json = json_encode($data, $flags | JSON_THROW_ON_ERROR, $depth);
        } catch (Throwable $exception) {
            throw new InvalidArgumentException($exception->getMessage(), (int)$exception->getCode(), $exception);
        }

        return $json;
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function decode(string $json, bool $assoc = true, int $depth = 512, int $flags = 0): mixed
    {
        try {
            $decode = json_decode($json, $assoc, $depth, $flags | JSON_THROW_ON_ERROR);
        } catch (Throwable $exception) {
            throw new InvalidArgumentException($exception->getMessage(), (int)$exception->getCode(), $exception);
        }

        return $decode;
    }
}
