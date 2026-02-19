<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $table = 'quotation';
    protected $primaryKey = 'id_quotation';
    protected $guarded = [];
    protected $casts = [
        'sent_at' => 'datetime',
        'expiry_date' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class, 'id_quotation', 'id_quotation')->orderBy('sort_order');
    }
}
