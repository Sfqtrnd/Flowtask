<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    protected $table = 'modul'; // pastikan sesuai nama tabel
    protected $fillable = [
        'kelas_id',       // FK → kelas.id
        'nama_modul',
        'deskripsi_modul',
        'deadline',       // datetime
    ];

    /**
     * Relasi: Modul ini milik satu Kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Relasi: Satu Modul punya banyak Submission (tugas mahasiswa)
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'modul_id');
    }
}
