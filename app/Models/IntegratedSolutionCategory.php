<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntegratedSolutionCategory extends Model
{
    use HasFactory;

    protected $table = 'integrated_solution_categories';
    protected $guarded = [];

    public function integratedSolution()
    {
        return $this->belongsTo(IntegratedSolution::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id_kategori');
    }

    public function getRandomSubcategories($limit = 4)
    {
        $kategori = $this->kategori;
        if (!$kategori) {
            return collect();
        }
        return $kategori->subkategori()->inRandomOrder()->limit($limit)->get();
    }
}
