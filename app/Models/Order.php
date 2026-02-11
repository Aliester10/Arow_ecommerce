<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';
    protected $primaryKey = 'id_order';
    protected $guarded = [];
    protected $casts = [
        'tanggal_order' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'id_order');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'id_order');
    }

    public function quotation()
    {
        return $this->hasOne(Quotation::class, 'id_order');
    }
}
