<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    private const CODE_LENGTH = 12;

    protected $fillable = [
        'name',
        'code',
        'amount',
        'used',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function(Model $model) {
            if (empty($model->code)) {
                $model->code = self::generateCode($model->id);
                $model->save();
            }
        });
    }

    private static function generateCode(int $id): string
    {
        return strtoupper(substr(sprintf('%s-%s', $id, Str::random()), 0, self::CODE_LENGTH));
    }
}
