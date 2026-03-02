<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Kandidat;

class KandidatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kandidats = [
            [
                'nama'        => 'Budi Santoso',
                'role'        => 'Staff',
                'perusahaan'  => 'PT Maju Bersama',
                'departemen'  => 'Human Resources',
                'role_target' => 'HR Manager',
                'username'    => 'budi.santoso',
                'password'    => 'password123',
            ],
            [
                'nama'        => 'Siti Rahayu',
                'role'        => 'Senior Staff',
                'perusahaan'  => 'PT Maju Bersama',
                'departemen'  => 'Finance',
                'role_target' => 'Finance Manager',
                'username'    => 'siti.rahayu',
                'password'    => 'password123',
            ],
            [
                'nama'        => 'Ahmad Fauzi',
                'role'        => 'Supervisor',
                'perusahaan'  => 'PT Maju Bersama',
                'departemen'  => 'Operations',
                'role_target' => 'Operations Manager',
                'username'    => 'ahmad.fauzi',
                'password'    => 'password123',
            ],
            [
                'nama'        => 'Dewi Kartika',
                'role'        => 'Junior Staff',
                'perusahaan'  => 'PT Maju Bersama',
                'departemen'  => 'Marketing',
                'role_target' => 'Marketing Specialist',
                'username'    => 'dewi.kartika',
                'password'    => 'password123',
            ],
            [
                'nama'        => 'Rizky Pratama',
                'role'        => 'Staff',
                'perusahaan'  => 'PT Maju Bersama',
                'departemen'  => 'Information Technology',
                'role_target' => 'IT Lead',
                'username'    => 'rizky.pratama',
                'password'    => 'password123',
            ],
        ];

        foreach ($kandidats as $data) {
            Kandidat::create($data);
        }

        $this->command->info('✅ KandidatSeeder berhasil dijalankan — ' . count($kandidats) . ' data kandidat ditambahkan.');
    }
}
