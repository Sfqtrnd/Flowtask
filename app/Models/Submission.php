<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 'submissions';
    protected $fillable = [
        'modul_id',           // FK → modul.id
        'mahasiswa_id',       // FK → users.id
        'judul_tugas',
        'deskripsi_tugas',    // nullable/text
        'file_path',          // string: path di storage
        'status_pengumpulan', // enum: 'Menunggu Nilai','Diterima','Revisi','Ditolak'
        'komentar_asdos',     // text, nullable
    ];

    /**
     * Relasi: Submission milik satu Modul
     */
    public function modul()
    {
        return $this->belongsTo(Modul::class, 'modul_id');
    }

    /**
     * Relasi: Submission milik satu Mahasiswa (User)
     */
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
