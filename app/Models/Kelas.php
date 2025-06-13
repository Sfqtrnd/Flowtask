<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas'; 
    protected $fillable = [
        'nama_kelas',
        'semester',
        'asdos_id', 
    ];

    /**
     * Relasi: Kelas dibuat satu asdos
     */
    public function asdos()
    {
        return $this->belongsTo(User::class, 'asdos_id');
    }

    /**
     * Relasi: Satu Kelas punya banyak Modul
     */
    public function modul()
    {
        return $this->hasMany(Modul::class, 'kelas_id');
    }
}
