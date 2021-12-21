<?php

namespace Database\Factories;

use App\Models\Product;
use App\TransferObject\ProductTransferObject;
use App\TransferObject\TransferObjectInterface;
use Illuminate\Database\Eloquent\Factories\Factory;
use Webmozart\Assert\Assert;

class ProductFactory extends Factory implements EntityFactoryInterface
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(255),
            'price' => $this->faker->randomFloat(2, 10, 999),
            'stock' => $this->faker->randomDigitNotZero(),
        ];
    }

    public function createFromTransferObject(TransferObjectInterface $transferObject): Product
    {
        Assert::isInstanceOf($transferObject, ProductTransferObject::class);

        return $this->create($transferObject->toArray());
    }
}
