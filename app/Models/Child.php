<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    /**
     * Los campos que se pueden asignar masivamente (mass assignable)
     */
    protected $fillable = [
        'name',
        'diagnosis',
        'age',
        'photo_path',
        'specialist_id',
        'parent_id',
        'overall_progress',
        'progress_communication',
        'progress_activities',
        'progress_routines',
        'progress_multimedia',
        'progress_autonomy',
    ];

    /**
     * Relación: un niño pertenece a un especialista (User)
     */
    public function specialist()
    {
        return $this->belongsTo(User::class, 'specialist_id');
    }

    /**
     * Relación: un niño tiene muchas actividades
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Relación: un niño tiene muchas rutinas
     */
    public function routines()
    {
        return $this->hasMany(Routine::class);
    }

    /**
     * Relación: un niño tiene muchos logros (achievements)
     */
    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    /**
     * Relación: un niño tiene muchos pictogramas
     */
    public function pictograms()
    {
        return $this->hasMany(Pictogram::class);
    }

    /**
     * Relación: un niño tiene muchas oraciones (sentences)
     */
    public function sentences()
    {
        return $this->hasMany(Sentence::class);
    }

    /**
     * Relación: un niño tiene muchos comentarios
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Relación: un niño tiene registros de sesiones (tea logs)
     */
    public function teaLogs()
    {
        return $this->hasMany(TeaLog::class);
    }
}
