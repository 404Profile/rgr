<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'payment_method',
        'delivery_method',
        'notes',
        'status',
        'total'
    ];

    protected $appends = [
        'status_text',
        'delivery_method_text'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            'pending' => 'Ожидает обработки',
            'processing' => 'В обработке',
            'completed' => 'Выполнен',
            'canceled' => 'Отменен',
            'delivered' => 'Доставлен',
            default => 'Неизвестно',
        };
    }

    public function getDeliveryMethodTextAttribute()
    {
        return match ($this->delivery_method) {
            'pickup' => 'Самовывоз',
            'delivery' => 'Доставка',
            default => 'Неизвестно',
        };
    }
}
