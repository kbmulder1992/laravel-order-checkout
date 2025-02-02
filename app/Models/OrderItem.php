<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'amount',
        'quantity',
    ];

    protected $guarded = [
        'order_id',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
