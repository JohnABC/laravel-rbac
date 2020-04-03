<?php

namespace LaravelRBAC\Traits;

trait HasController
{
    public function getRoles()
    {
        $roleModel = config('laravelrbac.models.role');
        $paginator = $roleModel::paginate(10);

        return view('laravelrbac::role.roles');
    }

    public function getRole()
    {

    }

    public function getPermissions()
    {

    }
}