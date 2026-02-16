<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    use HasFactory;

    protected $table = 'footer_links';
    protected $primaryKey = 'id_footer_link';

    protected $fillable = [
        'column_title',
        'type',
        'label',
        'url',
        'image_path',
        'order',
    ];
}
