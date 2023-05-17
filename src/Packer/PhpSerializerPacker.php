<?php

declare(strict_types=1);

namespace PeibinLaravel\Codec\Packer;

use PeibinLaravel\Contracts\PackerInterface;

class PhpSerializerPacker implements PackerInterface
{
    public function pack($data): string
    {
        return serialize($data);
    }

    public function unpack(string $data)
    {
        return unserialize($data);
    }
}
