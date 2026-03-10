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
        $deptIds = $this->seedDepartments();

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
            ['Officer', 3],
            ['Manager', 4],
            ['General Manager', 5],
            ['Board of Directors', 6],
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
        $roles = ['admin_pdc', 'talent', 'atasan', 'mentor', 'finance', 'board_of_directors'];
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
                'role_id' => $roleIds['admin_pdc'],
                'company_id' => $companyIds['PT. Tiga Serangkai Pustaka Mandiri'],
                'department_id' => $deptIds['Human Resources'],
                'position_id' => $posIds['Super Admin'],
            ],
            [
                'nama' => 'Rizky Pratama',
                'username' => 'rizky.pratama',
                'email' => 'rizky@mail.com',
                'password' => Hash::make('password123'),
                'role_id' => $roleIds['board_of_directors'],
                'company_id' => $companyIds['PT. Tiga Serangkai Pustaka Mandiri'],
                'department_id' => $deptIds['Board of Directors'],
                'position_id' => $posIds['Board of Directors'],
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
                // Secara berurutan membagikan mentor & atasan agar merata
                'mentor_id' => $mentorIdsDb[$index % count($mentorIdsDb)],
                'atasan_id' => $atasanIdsDb[$index % count($atasanIdsDb)],
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
