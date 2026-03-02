<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 1 user sample per role
        $users = [
            [
                'nama'       => 'Admin PDC',
                'username'   => 'admin.pdc',
                'password'   => Hash::make('password123'),
                'role'       => 'admin_pdc',
                'perusahaan' => 'PT Maju Bersama',
                'departemen' => 'Human Resources',
                'jabatan'    => 'People Development Center Admin',
            ],
            [
                'nama'       => 'Budi Santoso',
                'username'   => 'budi.santoso',
                'password'   => Hash::make('password123'),
                'role'       => 'kandidat',
                'perusahaan' => 'PT Maju Bersama',
                'departemen' => 'Operations',
                'jabatan'    => 'Supervisor',
                'jabatan_target' => 'Manager',
            ],
            [
                'nama'       => 'Siti Rahayu',
                'username'   => 'siti.rahayu',
                'password'   => Hash::make('password123'),
                'role'       => 'atasan',
                'perusahaan' => 'PT Maju Bersama',
                'departemen' => 'Operations',
                'jabatan'    => 'General Manager',
            ],
            [
                'nama'       => 'Ahmad Fauzi',
                'username'   => 'ahmad.fauzi',
                'password'   => Hash::make('password123'),
                'role'       => 'mentor',
                'perusahaan' => 'PT Maju Bersama',
                'departemen' => 'Human Resources',
                'jabatan'    => 'Senior Manager',
            ],
            [
                'nama'       => 'Dewi Kartika',
                'username'   => 'dewi.kartika',
                'password'   => Hash::make('password123'),
                'role'       => 'finance',
                'perusahaan' => 'PT Maju Bersama',
                'departemen' => 'Finance',
                'jabatan'    => 'Finance Manager',
            ],
            [
                'nama'       => 'Rizky Pratama',
                'username'   => 'rizky.pratama',
                'password'   => Hash::make('password123'),
                'role'       => 'bo_director',
                'perusahaan' => 'PT Maju Bersama',
                'departemen' => 'Board of Directors',
                'jabatan'    => 'BO Director',
            ],
        ];

        foreach ($users as $data) {
            User::create($data);
        }

        $this->command->info('✅ DatabaseSeeder selesai — ' . count($users) . ' user berhasil dibuat.');
    }
}
