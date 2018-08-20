<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SeedRolesAndPermissionsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 清除缓存
        app()['cache']->forget('spatie.permission.cache');

        // 先创建权限
        Permission::create(['name' => '课程与试卷管理']);
        Permission::create(['name' => '用户与权限管理']);
        Permission::create(['name' => '设置']);

        // 创建站长角色，并赋予权限
        $founder = Role::create(['name' => '超级管理员']);
        $founder->givePermissionTo('课程与试卷管理');
        $founder->givePermissionTo('用户与权限管理');
        $founder->givePermissionTo('设置');

        // 创建管理员角色，并赋予权限
        $maintainer = Role::create(['name' => '管理员']);
        $maintainer->givePermissionTo('课程与试卷管理');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 清除缓存
        app()['cache']->forget('spatie.permission.cache');

        // 清空所有数据表数据
        $tableNames = config('permission.table_names');

        Model::unguard();
        DB::table($tableNames['role_has_permissions'])->delete();
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['model_has_permissions'])->delete();
        DB::table($tableNames['roles'])->delete();
        DB::table($tableNames['permissions'])->delete();
        Model::reguard();
    }
}
