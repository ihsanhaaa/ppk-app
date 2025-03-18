<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => 'Pegawai', 
            'email' => 'pegawai@gmail.com',
            'password' => bcrypt('1234567890')
        ]);

        $role = Role::create(['name' => 'Pegawai']);

        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);
        

        // ketua stikes
        $ketua = User::create([
            'name' => 'Ketua', 
            'email' => 'ketua@gmail.com',
            'password' => bcrypt('1234567890')
        ]);

        $role = Role::create(['name' => 'Ketua']);
     
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $ketua->assignRole([$role->id]);

        // mahasiswa
        $role = Role::create(['name' => 'Mahasiswa']);
    }
}