<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalTask extends Model
{
    protected $table = 'personal_tasks';
    protected $fillable = [
        'mahasiswa_id', // FK → users.id
        'judul',
        'deskripsi',
        'status',       // enum: 'Belum Mulai','Sedang Berjalan','Selesai'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
