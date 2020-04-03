<?php

namespace LaravelRBAC\Traits;

trait HasRole
{
    /**
     * Permission belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        $relation = config('laravelrbac.tables.role_permission');

        return $this->belongsToMany(config('laravelrbac.models.permission'), $relation['table_name'], $relation['fields']['permission_id'], $relation['role_id']);
    }
}
