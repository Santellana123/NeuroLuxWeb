<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'title',
        'description',
        'earned_at',
        'created_at',
        'updated_at'
    ];

    public function child()
    {
        return $this->belongsTo(\App\Models\Child::class);
    }
}
