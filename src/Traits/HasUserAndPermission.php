<?php

namespace LaravelRBAC\Traits;

trait HasUserAndPermission
{
    /**
     * Role belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        $relation = config('laravelrbac.tables.role_user');

        return $this->belongsToMany(config('auth.model'), $relation['table_name'], $relation['fields']['role_id']['column'], $relation['fields']['user_id']['column']);
    }

    /**
     * Role belongs to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        $relation = config('laravelrbac.tables.role_permission');

        return $this->belongsToMany(config('laravelrbac.models.permission'), $relation['table_name'], $relation['fields']['role_id']['column'], $relation['fields']['permission_id']['column']);
    }

    /**
     * Sync permissions to a role
     * @param array $permissions
     * @return array
     */
    public function syncPermissions($permissions)
    {
        return $this->roles()->sync($permissions);
    }
}
