<?php

namespace App\TransferObject;

use Webmozart\Assert\Assert;

class ProductTransferObject implements TransferObjectInterface
{
    private string $name;
    private string $description;
    private float $price;
    private int $stock;

    private function __construct(string $name, string $description, float $price, int $stock)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
    }

    public static function create(string $name, string $description, float $price, int $stock): self
    {
        return new self($name, $description, $price, $stock);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
        ];
    }

    public function fromArray(array $array): TransferObjectInterface
    {
        Assert::notEmpty($array['name']);
        Assert::notEmpty($array['description']);
        Assert::float($array['price']);
        Assert::integer($array['stock']);

        return self::create($array['name'], $array['description'], $array['price'], $array['stock']);
    }
}
