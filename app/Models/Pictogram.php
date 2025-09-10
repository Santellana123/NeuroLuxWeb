<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pictogram extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'category',       // emociones, afirmacion, personas, bebidas, objetos, comidas, educativo
        'name',
        'image_path',
        'audio_path',
        'type',           // educativo, personalizado
        'created_at',
        'updated_at'
    ];

    public function child()
    {
        return $this->belongsTo(\App\Models\Child::class);
    }
}
