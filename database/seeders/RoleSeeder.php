<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Roles
        $admin = Role::create(['name' => 'Administrator']);
        $author = Role::create(['name' => 'Author']);

        //Permissions
        Permission::create([
            'name' => 'admin.index', 
            'description' => 'Ver el Dashboard'
        ])->syncRoles([$admin,$author]);

        Permission::create([
            'name' => 'categories.index',
            'description' => 'Ver Categorias'
        ])->syncRoles([$admin,$author]);

        Permission::create([
            'name' => 'categories.create',
            'description' => 'Crear Categorias'
        ])->syncRoles([$admin,$author]);
        Permission::create([
            'name' => 'categories.edit',
            'description' => 'Editar Categorias'
        ])->syncRoles([$admin,$author]);
        Permission::create([
            'name' => 'categories.destroy',
            'description' => 'Eliminar Categorias'
        ])->assignRole($admin);

        Permission::create([
            'name' => 'articles.index',
            'description' => 'Ver Articulos'
        ])->syncRoles([$admin,$author]);
        Permission::create([
            'name' => 'articles.create',
            'description' => 'Crear Articulos'
        ])->syncRoles([$admin,$author]);
        Permission::create([
            'name' => 'articles.edit',
            'description' => 'Editar Articulos'
        ])->syncRoles([$admin,$author]);
        Permission::create([
            'name' => 'articles.destroy',
            'description' => 'Eliminar Articulos'
        ])->syncRoles([$admin,$author]);

        Permission::create([
            'name' => 'comments.index',
            'description' => 'Ver Comentarios'
        ])->syncRoles([$admin,$author]);
        Permission::create([
            'name' => 'comments.destroy',
            'description' => 'Eliminar Comentarios'
        ])->syncRoles([$admin,$author]);

        Permission::create([
            'name' => 'users.index',
            'description' => 'Ver Usuarios'
        ])->syncRoles([$admin,$author]);
        Permission::create([
            'name' => 'users.edit',
            'description' => 'Editar Usuarios'
        ])->syncRoles([$admin,$author]);
        Permission::create([
            'name' => 'users.destroy',
            'description' => 'Eliminar Usuarios'
        ])->assignRole($admin);

        Permission::create([
            'name' => 'roles.index',
            'description' => 'Ver Roles'
        ])->assignRole($admin);
        Permission::create([
            'name' => 'roles.create',
            'description' => 'Crear Roles'
        ])->assignRole($admin);
        Permission::create([
            'name' => 'roles.edit',
            'description' => 'Editar Roles'
        ])->assignRole($admin);
        Permission::create([
            'name' => 'roles.destroy',
            'description' => 'Eliminar Roles'
        ])->assignRole($admin);
    }
}
