<?php

namespace App\TransferObject;

use Webmozart\Assert\Assert;

class CouponTransferObject implements TransferObjectInterface
{
    private string $name;
    private string $code;
    private float $amount;
    private bool $used;

    private function __construct(string $name, string $code, float $amount, bool $used)
    {
        $this->name = $name;
        $this->code = $code;
        $this->amount = $amount;
        $this->used = $used;
    }

    public static function create(string $name, string $code, float $amount, bool $used): self
    {
        return new self($name, $code, $amount, $used);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function isUsed(): bool
    {
        return $this->used;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
            'amount' => $this->amount,
            'used' => $this->used,
        ];
    }

    public function fromArray(array $array): TransferObjectInterface
    {
        Assert::notEmpty($array['name']);
        Assert::notEmpty($array['code']);
        Assert::float($array['amount']);
        Assert::boolean($array['used']);

        return self::create($array['name'], $array['code'], $array['amount'], $array['used']);
    }
}
