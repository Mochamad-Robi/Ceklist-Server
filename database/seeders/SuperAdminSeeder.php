<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah super admin sudah ada
        $superAdmin = User::where('email', 'superadmin@checklist.com')->first();
        
        if (!$superAdmin) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@checklist.com',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
            ]);
            
            $this->command->info('Super Admin created successfully!');
        } else {
            // Update role jika user sudah ada
            $superAdmin->update(['role' => 'super_admin']);
            $this->command->info('Super Admin role updated!');
        }
    }
}