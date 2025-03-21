<?php

namespace Database\Seeders;


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Öncelikle 'superadmin' rolünü alıyoruz
        $role = Role::firstOrCreate(['name' => 'superadmin']);

        // Kullanıcıyı oluşturuyoruz
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // Güçlü bir şifre kullanmayı unutmayın
        ]);

        // Kullanıcıya 'superadmin' rolünü atıyoruz
        $user->assignRole('superadmin'); // 'superadmin' rolünü atanıyor

        // Seeder başarıyla tamamlandı mesajı
        $this->command->info('Superadmin kullanıcısı oluşturuldu ve rol atandı.');
    }
}
