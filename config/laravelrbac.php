<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Package Connection
    |--------------------------------------------------------------------------
    |
    | You can set a different database connection for this package. It will set
    | new connection for models Role and Permission. When this option is null,
    | it will connect to the main database, which is set up in database.php
    |
    */

    'connection' => null,

    /*
    |--------------------------------------------------------------------------
    | Slug Separator
    |--------------------------------------------------------------------------
    |
    | Here you can change the slug separator. This is very important in matter
    | of magic method __call() and also a `Slugable` trait. The default value
    | is a dot.
    |
    */

    'separator' => '.',

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | If you want, you can replace default models from this package by models
    | you created. Have a look at `LaravelRBAC\Models\Role` model and
    | `LaravelRBAC\Models\Permission` model.
    |
    */

    'models' => [
        'role' => LaravelRBAC\Models\Role::class,
        'permission' => LaravelRBAC\Models\Permission::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | RBAC Controller
    |--------------------------------------------------------------------------
    |
    | Here you can change the default controller.
    |
    */
    'controller' => LaravelRBAC\Controllers\Controller::class,

    /*
    |--------------------------------------------------------------------------
    | Tables
    |--------------------------------------------------------------------------
    |
    | Here you can relation the field to your own table.
    |
    */
    'tables' => [
        'role' => [
            'fields' => [
                'id' => ['column' => 'id', 'validator' => 'required|int'],
                'name' => ['column' => 'name', 'validator' => 'required|string|max:32', 'label' => '角色名'],
                'slug' => ['column' => 'slug', 'validator' => 'required|string|max:128', 'label' => '标识'],
                'description' => ['column' => 'description', 'validator' => 'required|string|max:256', 'label' => '描述'],
            ],
        ],
        'role_user' => [
            'table_name' => 'admin_role_user',
            'fields' => [
                'id' => ['column' => 'id', 'validator' => 'required|int'],
                'user_id' => ['column' => 'user_id', 'validator' => 'required|int'],
                'role_id' => ['column' => 'role_id', 'validator' => 'required|int'],
            ],
        ],
        'permission' => [
            'fields' => [
                'id' => ['column' => 'id', 'validator' => 'required|int'],
                'name' => ['column' => 'name', 'validator' => 'required|string|max:32', 'label' => '权限名'],
                'slug' => ['column' => 'slug', 'validator' => 'required|string|max:128', 'label' => '标识'],
                'description' => ['column' => 'description', 'validator' => 'required|string|max:256', 'label' => '描述'],
            ],
        ],
        'role_permission' => [
            'table_name' => 'admin_role_permission',
            'fields' => [
                'id' => ['column' => 'id', 'validator' => 'required|int'],
                'role_id' => ['column' => 'role_id', 'validator' => 'required|int'],
                'permission_id' => ['column' => 'permission_id', 'validator' => 'required|int'],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Roles, Permissions and Allowed "Pretend"
    |--------------------------------------------------------------------------
    |
    | You can pretend or simulate package behavior no matter what is in your
    | database. It is really useful when you are testing you application.
    | Set up what will methods roleIs(), may() and allowed() return.
    |
    */

    'pretend' => [
        'enabled' => false,

        'options' => [
            'roleIs' => true,
            'may' => true,
            'allowed' => true,
        ],

    ],
];