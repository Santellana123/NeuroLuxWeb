<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'name',
        'type',
        'status',
        'created_at',
        'updated_at'
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
}
