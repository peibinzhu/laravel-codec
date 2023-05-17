<?php

declare(strict_types=1);

namespace PeibinLaravel\Codec\Packer;

use PeibinLaravel\Codec\Contracts\PackerInterface;

class JsonPacker implements PackerInterface
{
    public function pack($data): string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function unpack(string $data)
    {
        return json_decode($data, true);
    }
}
