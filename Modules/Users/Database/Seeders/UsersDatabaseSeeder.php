<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Users\App\Models\AdminGroup;
use Modules\Users\App\Models\AdminGroupRole;
use Modules\Users\App\Models\User;

class UsersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call([]);


        if (User::where('email', 'test@test.com')->count() == 0) {
            $group = AdminGroup::create(['name' => 'full admin']);


            $roles = [
                'Admins',
                'Users',
                'AdminGroups',
                'AdminGroupRoles',
                'Codes',
            ];
            foreach ($roles as $role) {
                AdminGroupRole::create([
                    'admin_group_id' => $group->id,
                    'resource' => $role,
                    'create' => 'yes',
                    'show' => 'yes',
                    'update' => 'yes',
                    'delete' => 'yes',
                    'force_delete' => 'yes',
                    'restore' => 'yes',
                ]);
            }


            User::firstOrCreate([
                'name'              => 'admin',
                'email'             => 'test@test.com',
                'first_name'        => 'test',
                'last_name'         => 'test',
                'password'          => bcrypt((string) 123456),
                'account_type'      => 'admin',
                'admin_group_id'    => $group->id,
                'email_verified_at' => now(),
            ]);
        }

        User::factory()->count(5)->create(
            ['password' => bcrypt((string) 123456)],
        );
    }
}
