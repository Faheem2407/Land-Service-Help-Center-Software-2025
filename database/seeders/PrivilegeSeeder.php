<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Privilege;

class PrivilegeSeeder extends Seeder
{
    public function run()
    {
        $admins = User::where('role', 'admin')->get();

        // Define ALL system modules with FULL permissions
        $modules = [
            'dashboard'   => ['view'],
            'categories'  => ['view', 'create', 'edit', 'delete'],
            'helpers'     => ['view', 'create', 'edit', 'delete'],
            'receivers'   => ['view', 'create', 'edit', 'delete'],
            'costs'       => ['view', 'create', 'edit', 'delete'],
            'cost_sources'=> ['view', 'create', 'edit', 'delete'],
            'reports'     => ['view'],
            'admins'      => ['view', 'create', 'edit', 'delete'],


            'privileges'  => ['view', 'edit'],

            'settings'    => ['view', 'edit'],
        ];

        foreach ($admins as $admin) {
            foreach ($modules as $module => $actions) {
                Privilege::updateOrCreate(
                    [
                        'user_id' => $admin->id,
                        'module'  => $module,
                    ],
                    [
                        'actions' => json_encode($actions),
                    ]
                );
            }
        }
    }
}
