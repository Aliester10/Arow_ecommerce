<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory;

    protected $table = 'quotation_items';

    protected $guarded = [];

    protected $casts = [
        'price' => 'decimal:2',
        'qty' => 'integer',
        'sort_order' => 'integer',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'id_quotation', 'id_quotation');
    }

    public function product()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
