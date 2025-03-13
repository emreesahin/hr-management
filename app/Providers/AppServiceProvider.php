<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // if(User::whereHas('roles', function($query){
        //     $query->where('name', 'hr');
        // })-> count() == 0) {
        //     $role = Role::firstOrCreate(['name' => 'hr']);

        //     $user = User::create([
        //         'name' => 'HR Super Admin',
        //         'email' => 'hr@company.com',
        //         'password' => Hash::make('admin123')
        //     ]);

        //     $user->assignRole($role);

        //     \Log::info('Created HR Super Admin');
        // }


        Schema::defaultStringLength(191);
    }
}
