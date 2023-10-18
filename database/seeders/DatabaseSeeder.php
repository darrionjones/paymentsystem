<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('users')->truncate();
        DB::table('transactions')->truncate();
        $this->call([TransactionSeeder::class]);

        $this->call([UsersTableSeeder::class]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->call([RegionsTableSeeder::class, RolesAndPermissionsSeeder::class, AssignRolesToAdminUserSeeder::class]);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call([BankSeeder::class, BranchSeeder::class]);

    }
}
