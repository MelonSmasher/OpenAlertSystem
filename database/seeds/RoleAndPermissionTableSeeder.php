<?php

use Illuminate\Database\Seeder;
use App\Model\Role;
use App\Model\Permission;

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
            'name' => 'send-sms',
            'display_name' => 'Send SMS',
            'description' => 'Can send SMS messages to recipients.',
        ]);

        $sendEmail = Permission::create([
            'name' => 'send-email',
            'display_name' => 'Send Email',
            'description' => 'Can send email messages to recipients.',
        ]);

        $editSettings = Permission::create([
            'name' => 'edit-settings',
            'display_name' => 'Edit Settings',
            'description' => 'Can edit application settings.',
        ]);

        $manageUsers = Permission::create([
            'name' => 'manage-users',
            'display_name' => 'Manage Users',
            'description' => 'Can manage users and their roles.',
        ]);

        /**
         * ROLES
         */

        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'An application administrator. Can control any aspect of the application.'
        ]);

        $powerUser = Role::create([
            'name' => 'power-user',
            'display_name' => 'Power User',
            'description' => 'An application power user can has the ability to manage users accounts and send email and SMS messages.'
        ]);

        $notifier = Role::create([
            'name' => 'notifier',
            'display_name' => 'Notifier',
            'description' => 'A notifier has the ability to send both email and SMS messages.'
        ]);

        Role::create([
            'name' => 'application-user',
            'display_name' => 'Application User',
            'description' => 'An application user has no permissions and is intended for front end users.'
        ]);

        /**
         * Permission Delegation
         */

        $admin->attachPermissions(Permission::all());

        $powerUser->attachPermissions([
            $manageUsers,
            $sendSMS,
            $sendEmail
        ]);

        $notifier->attachPermissions([
            $sendSMS,
            $sendEmail
        ]);
    }
}
