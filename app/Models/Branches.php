<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branches extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
    ];

    public function menus()
    {
        return $this->hasMany(Menus::class, 'branch_id');
    }
}
