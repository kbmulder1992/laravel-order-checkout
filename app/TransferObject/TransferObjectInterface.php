<?php

namespace App\TransferObject;

interface TransferObjectInterface
{
    public function toArray(): array;
    public function fromArray(array $array): TransferObjectInterface;
}
