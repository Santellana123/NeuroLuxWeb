<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{
    use HasFactory;

    protected $fillable = [
        'child_id',
        'sentence',
        'audio_path',
        'created_at',
        'updated_at'
    ];

    // Relación con Child
    public function child()
    {
        return $this->belongsTo(\App\Models\Child::class);
    }

    // Relación many-to-many con Pictogram
    public function pictograms()
    {
        return $this->belongsToMany(\App\Models\Pictogram::class, 'sentence_pictogram', 'sentence_id', 'pictogram_id');
    }
}
