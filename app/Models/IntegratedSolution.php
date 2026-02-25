<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntegratedSolution extends Model
{
    use HasFactory;

    protected $table = 'integrated_solutions';
    protected $guarded = [];

    public function categories()
    {
        return $this->hasMany(IntegratedSolutionCategory::class);
    }

    public function activeCategories()
    {
        return $this->hasMany(IntegratedSolutionCategory::class)->where('is_active', true)->orderBy('sort_order');
    }
}
