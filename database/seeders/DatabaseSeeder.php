<?php

namespace Database\Seeders;

use App\Enums\User\RoleEnum;
use App\Enums\User\StatusEnum;
use App\Models\Address;
use App\Models\Billing;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Department;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('app:database-remap');

        $adminUser = User::factory()->create([
            'branch_id' => 1,
            'email' => 'admin@test.com',
            'status' => StatusEnum::ACCEPTED,
            'role' => RoleEnum::ADMIN,
        ]);

        Address::factory(1)->create([
            'user_id' => $adminUser->id
        ]);

        Billing::factory(1)->create([
            'user_id' => $adminUser->id
        ]);
    }
}
