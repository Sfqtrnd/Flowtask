<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1 akun Asdos
        User::create([
            'name'     => 'Asisten Dosen Utama',
            'email'    => 'asdos@example.com',
            'password' => Hash::make('password'),
            'role'     => 'asdos',
        ]);

        // Beberapa akun Mahasiswa
        $mahasiswas = [
            ['name'=>'Sopi','email'=>'mahasiswa@example.com'],
            ['name'=>'Avav','email'=>'avav@example.com'],
            ['name'=>'Citra Lestari','email'=>'citra@example.com'],
            ['name'=>'Diana Putri','email'=>'diana@example.com'],
            ['name'=>'Eka Putri','email'=>'eka@example.com'],
        ];

        foreach ($mahasiswas as $mhs) {
            User::create([
                'name'     => $mhs['name'],
                'email'    => $mhs['email'],
                'password' => Hash::make('password'),
                'role'     => 'mahasiswa',
            ]);
        }

    }
}
