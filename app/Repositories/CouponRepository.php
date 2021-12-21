<?php

namespace App\Repositories;

use App\Models\Coupon;

class CouponRepository
{
    public function getByCode(string $code): Coupon
    {
        return Coupon::where(['code' => $code])->firstOrFail();
    }
}
