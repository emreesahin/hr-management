<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $hrRole = Role::create(['name' => 'hr']);

       $hrUser = User::create([
            'name' => 'HR User',
            'email' => 'hr@company.com',
            'password' => Hash::make('password')
       ]);

       $hrUser->assignRole($hrRole);
    }


}
