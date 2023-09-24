<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->state([
                'name' => 'Admin',
                'email' => config('app.admin_email'),
                'password' => bcrypt(config('app.admin_password'))
            ])
            ->create()
            ->assignRole(Role::ADMIN);

        if (config('app.env') === 'local') {
            $i = 0;
            while ($i <= 25){
                $i++;
                User::factory()
                    ->create()
                    ->assignRole(Role::USER);
            }
        }
    }
}
