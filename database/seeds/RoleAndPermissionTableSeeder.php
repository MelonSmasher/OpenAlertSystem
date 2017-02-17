<?php

use Illuminate\Database\Seeder;
use Backpack\PermissionManager\app\Models\Role;
use Backpack\PermissionManager\app\Models\Permission;

class RoleAndPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Permissions
         */

        $sendSMS = Permission::create([
            'name' => 'send-sms'
        ]);

        $sendEmail = Permission::create([
            'name' => 'send-email'
        ]);

        $manageUsers = Permission::create([
            'name' => 'manage-users'
        ]);

        $viewToken = Permission::create([
            'name' => 'view-token'
        ]);

        /**
         * ROLES
         */

        $admin = Role::create([
            'name' => 'admin'
        ]);

        $powerUser = Role::create([
            'name' => 'power-user'
        ]);

        $notifier = Role::create([
            'name' => 'notifier'
        ]);

        Role::create([
            'name' => 'application-user'
        ]);

        /**
         * Permission Delegation
         */

        $admin->givePermissionTo(Permission::all());

        $powerUser->givePermissionTo([
            $manageUsers,
            $sendSMS,
            $sendEmail,
            $viewToken
        ]);

        $notifier->givePermissionTo([
            $sendSMS,
            $sendEmail
        ]);
    }
}
