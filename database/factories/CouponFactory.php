<?php

namespace Database\Factories;

use App\Models\Coupon;
use App\TransferObject\CouponTransferObject;
use App\TransferObject\TransferObjectInterface;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Webmozart\Assert\Assert;

class CouponFactory extends Factory implements EntityFactoryInterface
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $amount = $this->faker->randomFloat(2, 5, 30);

        return [
            'name' => sprintf('Coupon (€ %f)', $amount),
            'amount' => $amount,
            'used' => false,
        ];
    }

    public function createFromTransferObject(TransferObjectInterface $transferObject): Coupon
    {
        Assert::isInstanceOf($transferObject, CouponTransferObject::class);

        return $this->create($transferObject->toArray());
    }
}
