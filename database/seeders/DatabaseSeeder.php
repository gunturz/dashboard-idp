<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Company
        $companyId = $this->seedCompany();

        // Seed Departments
        $deptIds = $this->seedDepartments();

        // Seed Positions
        $posIds = $this->seedPositions();

        // Seed Roles
        $roleIds = $this->seedRoles();

        // Seed Users
        $userIds = $this->seedUsers($companyId, $deptIds, $posIds);

        // Seed IDP Types
        $this->seedIdpTypes();

        $this->command->info('✅ DatabaseSeeder completed successfully!');
        $this->command->info('   • Company: 1');
        $this->command->info('   • Departments: 4');
        $this->command->info('   • Positions: 6');
        $this->command->info('   • Roles: 6');
        $this->command->info('   • Users: 5');
        $this->command->info('   • IDP Types: 3');
    }

    /**
     * Seed company table
     */
    private function seedCompany(): int
    {
        return DB::table('company')->insertGetId([
            'nama_perusahaan' => 'PT Maju Bersama',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Seed departments
     */
    private function seedDepartments(): array
    {
        $departments = ['Human Resources', 'Operations', 'Finance', 'Board of Directors'];
        $deptIds = [];

        foreach ($departments as $name) {
            $deptIds[$name] = DB::table('department')->insertGetId([
                'nama_department' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $deptIds;
    }

    /**
     * Seed positions
     */
    private function seedPositions(): array
    {
        $positions = [
            ['Staff', 1],
            ['Supervisor', 2],
            ['Manager', 3],
            ['General Manager', 4],
            ['BO Director', 5],
            ['PDC', 6]
        ];
        $posIds = [];

        foreach ($positions as [$name, $grade]) {
            $posIds[$name] = DB::table('position')->insertGetId([
                'position_name' => $name,
                'grade_level' => $grade,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $posIds;
    }

    /**
     * Seed roles
     */
    private function seedRoles(): array
    {
        $roles = ['admin_pdc', 'kandidat', 'atasan', 'mentor', 'finance', 'bo_director'];
        $roleIds = [];

        foreach ($roles as $r) {
            $roleIds[$r] = DB::table('role')->insertGetId([
                'role_name' => $r,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $roleIds;
    }

    /**
     * Seed users and link roles
     */
    private function seedUsers(int $companyId, array $deptIds, array $posIds): array
    {
        $users = [
            [
                'nama_lengkap' => 'Admin PDC',
                'username' => 'admin.pdc',
                'password' => Hash::make('password123'),
                'role' => 'admin_pdc',
                'perusahaan_id' => $companyId,
                'department_id' => $deptIds['Human Resources'],
                'position_id' => $posIds['PDC'],
            ],
            [
                'nama_lengkap' => 'Budi Santoso',
                'username' => 'budi.santoso',
                'password' => Hash::make('password123'),
                'role' => 'kandidat',
                'perusahaan_id' => $companyId,
                'department_id' => $deptIds['Operations'],
                'position_id' => $posIds['Supervisor'],
            ],
            [
                'nama_lengkap' => 'Siti Rahayu',
                'username' => 'siti.rahayu',
                'password' => Hash::make('password123'),
                'role' => 'atasan',
                'perusahaan_id' => $companyId,
                'department_id' => $deptIds['Operations'],
                'position_id' => $posIds['Manager'],
            ],
            [
                'nama_lengkap' => 'Ahmad Fauzi',
                'username' => 'ahmad.fauzi',
                'password' => Hash::make('password123'),
                'role' => 'mentor',
                'perusahaan_id' => $companyId,
                'department_id' => $deptIds['Human Resources'],
                'position_id' => $posIds['General Manager'],
            ],
            [
                'nama_lengkap' => 'Rizky Pratama',
                'username' => 'rizky.pratama',
                'password' => Hash::make('password123'),
                'role' => 'bo_director',
                'perusahaan_id' => $companyId,
                'department_id' => $deptIds['Board of Directors'],
                'position_id' => $posIds['BO Director'],
            ],
        ];

        $userIds = [];
        foreach ($users as $user) {
            $role = $user['role'];
            // Jangan hapus role agar masuk ke tabel users
            
            $userId = DB::table('users')->insertGetId([
                ...$user,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $userIds[$role] = $userId;

            // Link user to role in user_role table
            $roleId = DB::table('role')->where('role_name', $role)->first()?->id;
            if ($roleId) {
                DB::table('user_role')->insert([
                    'id_user' => $userId,
                    'id_role' => $roleId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return $userIds;
    }

    /**
     * Seed IDP types
     */
    private function seedIdpTypes(): void
    {
        DB::table('idp_type')->insert([
            [
                'type_name' => 'Exposure',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type_name' => 'Mentoring',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type_name' => 'Learning',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
