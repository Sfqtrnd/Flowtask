<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas'; // pastikan sesuai nama tabel
    protected $fillable = [
        'nama_kelas',
        'semester',
        'asdos_id', // FK ke users.id (role = 'asdos')
    ];

    /**
     * Relasi: Kelas dibuat oleh satu Asdos (User)
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
