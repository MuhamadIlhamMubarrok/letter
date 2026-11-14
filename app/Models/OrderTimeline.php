<?php

namespace App\Models;

use App\Admin\Order\Model\Order;
use App\Core\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderTimeline extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'status',
        'notes',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getStatusEnumAttribute(): ?OrderStatusEnum
    {
        return OrderStatusEnum::tryFrom($this->status);
    }
}
