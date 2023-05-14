<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadminRole = Role::create(['name' => 'superadmin']);
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'edit role']);
        Permission::create(['name' => 'delete role']);
        Permission::create(['name' => 'show role']);

        $superadminRole->givePermissionTo('create role');
        $superadminRole->givePermissionTo('edit role');
        $superadminRole->givePermissionTo('delete role');
        $superadminRole->givePermissionTo('show role');

        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'show user']);

        $superadminRole->givePermissionTo('create user');
        $superadminRole->givePermissionTo('edit user');
        $superadminRole->givePermissionTo('delete user');
        $superadminRole->givePermissionTo('show user');

        Permission::create(['name' => 'create mode']);
        Permission::create(['name' => 'edit mode']);
        Permission::create(['name' => 'delete mode']);
        Permission::create(['name' => 'show mode']);

        $superadminRole->givePermissionTo('create mode');
        $superadminRole->givePermissionTo('edit mode');
        $superadminRole->givePermissionTo('delete mode');
        $superadminRole->givePermissionTo('show mode');

        $adminRole->givePermissionTo('create mode');
        $adminRole->givePermissionTo('edit mode');
        $adminRole->givePermissionTo('delete mode');
        $adminRole->givePermissionTo('show mode');


        Permission::create(['name' => 'create languages']);
        Permission::create(['name' => 'edit languages']);
        Permission::create(['name' => 'delete languages']);
        Permission::create(['name' => 'show languages']);

        $superadminRole->givePermissionTo('create languages');
        $superadminRole->givePermissionTo('edit languages');
        $superadminRole->givePermissionTo('delete languages');
        $superadminRole->givePermissionTo('show languages');

        $adminRole->givePermissionTo('create languages');
        $adminRole->givePermissionTo('edit languages');
        $adminRole->givePermissionTo('delete languages');
        $adminRole->givePermissionTo('show languages');

        Permission::create(['name' => 'create rank']);
        Permission::create(['name' => 'edit rank']);
        Permission::create(['name' => 'delete rank']);
        Permission::create(['name' => 'show rank']);

        $superadminRole->givePermissionTo('create rank');
        $superadminRole->givePermissionTo('edit rank');
        $superadminRole->givePermissionTo('delete rank');
        $superadminRole->givePermissionTo('show rank');

        $adminRole->givePermissionTo('create rank');
        $adminRole->givePermissionTo('edit rank');
        $adminRole->givePermissionTo('delete rank');
        $adminRole->givePermissionTo('show rank');

        Permission::create(['name' => 'create help']);
        Permission::create(['name' => 'edit help']);
        Permission::create(['name' => 'delete help']);
        Permission::create(['name' => 'show help']);

        $superadminRole->givePermissionTo('create help');
        $superadminRole->givePermissionTo('edit help');
        $superadminRole->givePermissionTo('delete help');
        $superadminRole->givePermissionTo('show help');

        $adminRole->givePermissionTo('create help');
        $adminRole->givePermissionTo('edit help');
        $adminRole->givePermissionTo('delete help');
        $adminRole->givePermissionTo('show help');

        Permission::create(['name' => 'create category']);
        Permission::create(['name' => 'edit category']);
        Permission::create(['name' => 'delete category']);
        Permission::create(['name' => 'show category']);

        $adminRole->givePermissionTo('create category');
        $adminRole->givePermissionTo('edit category');
        $adminRole->givePermissionTo('delete category');
        $adminRole->givePermissionTo('show category');

        Permission::create(['name' => 'create challenge']);
        Permission::create(['name' => 'edit challenge']);
        Permission::create(['name' => 'delete challenge']);
        Permission::create(['name' => 'show challenge']);

        $superadminRole->givePermissionTo('create challenge');
        $superadminRole->givePermissionTo('edit challenge');
        $superadminRole->givePermissionTo('delete challenge');
        $superadminRole->givePermissionTo('show challenge');

        $adminRole->givePermissionTo('create challenge');
        $adminRole->givePermissionTo('edit challenge');
        $adminRole->givePermissionTo('delete challenge');
        $adminRole->givePermissionTo('show challenge');

        $userRole->givePermissionTo('create challenge');
        $userRole->givePermissionTo('edit challenge');

        Permission::create(['name' => 'create videosolution']);
        Permission::create(['name' => 'edit videosolution']);
        Permission::create(['name' => 'delete videosolution']);
        Permission::create(['name' => 'show videosolution']);

        $superadminRole->givePermissionTo('create videosolution');
        $superadminRole->givePermissionTo('edit videosolution');
        $superadminRole->givePermissionTo('delete videosolution');
        $superadminRole->givePermissionTo('show videosolution');

        $adminRole->givePermissionTo('create videosolution');
        $adminRole->givePermissionTo('edit videosolution');
        $adminRole->givePermissionTo('delete videosolution');
        $adminRole->givePermissionTo('show videosolution');

        Permission::create(['name' => 'create score']);
        Permission::create(['name' => 'edit score']);
        Permission::create(['name' => 'delete score']);
        Permission::create(['name' => 'show score']);

        $superadminRole->givePermissionTo('create score');
        $superadminRole->givePermissionTo('edit score');
        $superadminRole->givePermissionTo('delete score');
        $superadminRole->givePermissionTo('show score');

        $adminRole->givePermissionTo('create score');
        $adminRole->givePermissionTo('edit score');
        $adminRole->givePermissionTo('delete score');
        $adminRole->givePermissionTo('show score');

        Permission::create(['name' => 'create resource']);
        Permission::create(['name' => 'edit resource']);
        Permission::create(['name' => 'delete resource']);
        Permission::create(['name' => 'show resource']);

        $superadminRole->givePermissionTo('create resource');
        $superadminRole->givePermissionTo('edit resource');
        $superadminRole->givePermissionTo('delete resource');
        $superadminRole->givePermissionTo('show resource');

        $adminRole->givePermissionTo('create resource');
        $adminRole->givePermissionTo('edit resource');
        $adminRole->givePermissionTo('delete resource');
        $adminRole->givePermissionTo('show resource');

        $userRole->givePermissionTo('create resource');
        $userRole->givePermissionTo('edit resource');

        Permission::create(['name' => 'create kataway']);
        Permission::create(['name' => 'edit kataway']);
        Permission::create(['name' => 'delete kataway']);
        Permission::create(['name' => 'show kataway']);

        $superadminRole->givePermissionTo('create kataway');
        $superadminRole->givePermissionTo('edit kataway');
        $superadminRole->givePermissionTo('delete kataway');
        $superadminRole->givePermissionTo('show kataway');

        $adminRole->givePermissionTo('create kataway');
        $adminRole->givePermissionTo('edit kataway');
        $adminRole->givePermissionTo('delete kataway');
        $adminRole->givePermissionTo('show kataway');


        Permission::create(['name' => 'create kumite']);
        Permission::create(['name' => 'edit kumite']);
        Permission::create(['name' => 'delete kumite']);
        Permission::create(['name' => 'show kumite']);

        $superadminRole->givePermissionTo('create kumite');
        $superadminRole->givePermissionTo('edit kumite');
        $superadminRole->givePermissionTo('delete kumite');
        $superadminRole->givePermissionTo('show kumite');

        $adminRole->givePermissionTo('create kumite');
        $adminRole->givePermissionTo('edit kumite');
        $adminRole->givePermissionTo('delete kumite');
        $adminRole->givePermissionTo('show kumite');

        Permission::create(['name' => 'create message']);
        Permission::create(['name' => 'delete message']);
        Permission::create(['name' => 'show message']);

        $superadminRole->givePermissionTo('create message');
        $superadminRole->givePermissionTo('delete message');
        $superadminRole->givePermissionTo('show message');

        $adminRole->givePermissionTo('create message');
        $adminRole->givePermissionTo('delete message');
        $adminRole->givePermissionTo('show message');

        $userRole->givePermissionTo('create message');
        $userRole->givePermissionTo('delete message');

        Permission::create(['name' => 'create order']);
        Permission::create(['name' => 'edit order']);
        Permission::create(['name' => 'delete order']);
        Permission::create(['name' => 'show order']);

        $superadminRole->givePermissionTo('create order');
        $superadminRole->givePermissionTo('edit order');
        $superadminRole->givePermissionTo('delete order');
        $superadminRole->givePermissionTo('show order');

        $adminRole->givePermissionTo('create order');
        $adminRole->givePermissionTo('edit order');
        $adminRole->givePermissionTo('delete order');
        $adminRole->givePermissionTo('show order');


        Permission::create(['name' => 'create clan']);
        Permission::create(['name' => 'edit clan']);
        Permission::create(['name' => 'delete clan']);
        Permission::create(['name' => 'show clan']);

        $superadminRole->givePermissionTo('create clan');
        $superadminRole->givePermissionTo('edit clan');
        $superadminRole->givePermissionTo('delete clan');
        $superadminRole->givePermissionTo('show clan');

        $adminRole->givePermissionTo('create clan');
        $adminRole->givePermissionTo('edit clan');
        $adminRole->givePermissionTo('delete clan');
        $adminRole->givePermissionTo('show clan');

        $userRole->givePermissionTo('create clan');
        $userRole->givePermissionTo('edit clan');
        $userRole->givePermissionTo('delete clan');
        $userRole->givePermissionTo('show clan');

    }
}
