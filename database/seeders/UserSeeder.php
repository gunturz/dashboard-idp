<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Company
        $companyIds = $this->seedCompany();

        // Seed Departments
        $deptIds = $this->seedDepartments($companyIds);

        // Seed Positions
        $posIds = $this->seedPositions();

        // Seed Roles
        $roleIds = $this->seedRoles();

        // Seed Users
        $userIds = $this->seedUsers($roleIds, $companyIds, $deptIds, $posIds);

        // Seed IDP Types
        $this->seedIdpTypes();

        $this->command->info('✅ DatabaseSeeder completed successfully!');
        $this->command->info('   • Company: 5');
        $this->command->info('   • Departments: 4');
        $this->command->info('   • Positions: 7');
        $this->command->info('   • Roles: 6');
        $this->command->info('   • Users: 17');
        $this->command->info('   • IDP Types: 3');
    }

    /**
     * Seed company table
     */
    private function seedCompany(): array
    {
        $companys = ['PT. Tiga Serangkai Inti Corpora', 'PT. Tiga Serangkai Pustaka Mandiri', 'PT. Wangsa Jatra Lestari', 'Assalam Hypermarket', 'PT. K33 Distribusi'];
        $compIds = [];

        foreach ($companys as $name) {
            $compIds[$name] = DB::table('company')->insertGetId([
                'nama_company' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return $compIds;
    }

    /**
     * Seed departments — one set per company, keyed by first company for user seeding
     */
    private function seedDepartments(array $companyIds): array
    {
        $departmentNames = ['Human Resources', 'Operations', 'Finance'];
        $deptIds = [];

        foreach ($companyIds as $companyName => $companyId) {
            foreach ($departmentNames as $name) {
                $insertedId = DB::table('department')->insertGetId([
                    'nama_department' => $name,
                    'company_id' => $companyId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Key by name only for the FIRST company (so seedUsers can reference them)
                if (!isset($deptIds[$name])) {
                    $deptIds[$name] = $insertedId;
                }
            }
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
            ['Officer', 3],
            ['Manager', 4],
            ['General Manager', 5],
            ['Panelis', 6],
            ['Super Admin', 7],
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
        $roles = ['admin', 'talent', 'atasan', 'mentor', 'finance', 'panelis'];
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
    private function seedUsers(array $roleIds, array $companyIds, array $deptIds, array $posIds): array
    {
        $users = [
            [
                'nama' => 'Admin PDC',
                'username' => 'admin.pdc',
                'email' => 'pdc@admin.com',
                'password' => Hash::make('password123'),
                'role_id' => $roleIds['admin'],
                'company_id' => $companyIds['PT. Tiga Serangkai Pustaka Mandiri'],
                'department_id' => $deptIds['Human Resources'],
                'position_id' => $posIds['Super Admin'],
            ],
            [
                'nama' => 'Rizky Pratama',
                'username' => 'rizky.pratama',
                'email' => 'rizky@mail.com',
                'password' => Hash::make('password123'),
                'role_id' => $roleIds['panelis'],
                'company_id' => $companyIds['PT. Tiga Serangkai Pustaka Mandiri'],
                'department_id' => $deptIds['Human Resources'],
                'position_id' => $posIds['Panelis'],
            ],
        ];

        // 5 User Talent
        for ($i = 1; $i <= 5; $i++) {
            $users[] = [
                'nama' => "Talent $i",
                'username' => "talent$i",
                'email' => "talent$i@mail.com",
                'password' => Hash::make('password123'),
                'role_id' => $roleIds['talent'],
                'company_id' => $companyIds['PT. Tiga Serangkai Pustaka Mandiri'],
                'department_id' => $deptIds['Operations'],
                'position_id' => $posIds['Staff'],
            ];
        }

        // 5 User Atasan
        for ($i = 1; $i <= 5; $i++) {
            $users[] = [
                'nama' => "Atasan $i",
                'username' => "atasan$i",
                'email' => "atasan$i@mail.com",
                'password' => Hash::make('password123'),
                'role_id' => $roleIds['atasan'],
                'company_id' => $companyIds['PT. Tiga Serangkai Pustaka Mandiri'],
                'department_id' => $deptIds['Operations'],
                'position_id' => $posIds['Manager'],
            ];
        }

        // 5 User Mentor
        for ($i = 1; $i <= 5; $i++) {
            $users[] = [
                'nama' => "Mentor $i",
                'username' => "mentor$i",
                'email' => "mentor$i@mail.com",
                'password' => Hash::make('password123'),
                'role_id' => $roleIds['mentor'],
                'company_id' => $companyIds['PT. Tiga Serangkai Pustaka Mandiri'],
                'department_id' => $deptIds['Human Resources'],
                'position_id' => $posIds['General Manager'],
            ];
        }

        // 5 User Finance
        for ($i = 1; $i <= 5; $i++) {
            $users[] = [
                'nama' => "Finance $i",
                'username' => "finance$i",
                'email' => "finance$i@mail.com",
                'password' => Hash::make('password123'),
                'role_id' => $roleIds['finance'],
                'company_id' => $companyIds['PT. Tiga Serangkai Pustaka Mandiri'],
                'department_id' => $deptIds['Finance'],
                'position_id' => $posIds['Manager'],
            ];
        }

        $userIds = [];
        foreach ($users as $user) {
            $role = $user['role_id'];
            // unset($user['role_id']);

            $userId = DB::table('users')->insertGetId([
                ...$user,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $userIds[$role] = $userId;

            // Link user to role in user_role table
            DB::table('user_role')->insert([
                'id_user' => $userId,
                'id_role' => $role,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Tetapkan Atasan dan Mentor secara otomatis kepada Talent
        $mentorIdsDb = DB::table('users')->where('role_id', $roleIds['mentor'])->pluck('id');
        $atasanIdsDb = DB::table('users')->where('role_id', $roleIds['atasan'])->pluck('id');
        $talentIdsDb = DB::table('users')->where('role_id', $roleIds['talent'])->pluck('id');

        foreach ($talentIdsDb as $index => $talentId) {
            DB::table('users')->where('id', $talentId)->update([
                'mentor_id' => $mentorIdsDb[$index % count($mentorIdsDb)],
                'atasan_id' => $atasanIdsDb[$index % count($atasanIdsDb)],
            ]);

            // Tambahkan Promotion Plan agar muncul di PDC Admin Dashboard
            // Variasikan target posisi: 4 (Manager), 5 (General Manager), 2 (Supervisor)
            $targetPosId = [4, 5, 2][$index % 3];
            DB::table('promotion_plan')->insert([
                'user_id_talent' => $talentId,
                'target_position_id' => $targetPosId,
                'mentor_ids' => json_encode([(string)$mentorIdsDb[$index % count($mentorIdsDb)]]),
                'status_promotion' => 'In Progress',
                'start_date' => now(),
                'target_date' => now()->addYear(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
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
