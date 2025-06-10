<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

       /**
     * Relasi: jika role = 'asdos', Asdos punya banyak Kelas
     */
    public function kelasYangDibuat()
    {
        return $this->hasMany(Kelas::class, 'asdos_id');
    }

    /**
     * Relasi: Mahasiswa punya banyak Submission (tugas praktikum)
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'mahasiswa_id');
    }

    /**
     * Relasi: Mahasiswa punya banyak PersonalTask (tugas pribadi)
     */
    public function personalTasks()
    {
        return $this->hasMany(PersonalTask::class, 'mahasiswa_id');
    }
}
