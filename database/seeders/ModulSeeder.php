<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Modul;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ModulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Untuk setiap kelas, tambahkan 3–4 modul
        $kelasList = Kelas::all();

        foreach ($kelasList as $kelas) {
            for ($i = 1; $i <= 4; $i++) {
                Modul::create([
                    'nama_modul'     => "Modul {$i}: Topik ".ucfirst(strtolower(Str::random(5))),
                    'deskripsi_modul'=> "Deskripsi singkat untuk modul {$i} di kelas {$kelas->nama_kelas}.",
                    'deadline'       => Carbon::now()->addDays(7 * $i),
                    'kelas_id'       => $kelas->id,
                ]);
            }
        }
    }
}
