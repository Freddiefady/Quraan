<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [];
        foreach(config('authorization.permissions') as $permission=>$value)
        {
            $permissions[] = $permission;
        }
        Roles::create([
            'role'=>'Owner',
            'permissions'=>json_encode($permissions),
        ]);
    }
}
