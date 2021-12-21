<?php

namespace Database\Factories;

use App\TransferObject\TransferObjectInterface;
use Illuminate\Database\Eloquent\Model;

interface EntityFactoryInterface
{
    public function createFromTransferObject(TransferObjectInterface $transferObject): Model;
}
