<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    protected $table = 'menus'; // <--- tambah ini
    protected $casts = [
        'rekomendasi' => 'boolean',
    ];

    protected $fillable = [
        'branch_id',
        'name',
        'description',
        'price',
        'image',
        'rekomendasi',
    ];

    public function branch()
    {
        return $this->belongsTo(Branches::class, 'branch_id');
    }
}
