<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari akun Asdos untuk assign kelas
        $asdos = User::where('role','asdos')->first();

        $daftarKelas = [
            ['nama_kelas'=>'Praktikum Struktur Data','semester'=>'Genap 2025'],
            ['nama_kelas'=>'Praktikum Basis Data','semester'=>'Genap 2025'],
            ['nama_kelas'=>'Praktikum Web Lanjut','semester'=>'Genap 2025'],
        ];

        foreach ($daftarKelas as $kelas) {
            Kelas::create([
                'nama_kelas' => $kelas['nama_kelas'],
                'semester'   => $kelas['semester'],
                'asdos_id'   => $asdos->id,
            ]);
        }
    }
}
