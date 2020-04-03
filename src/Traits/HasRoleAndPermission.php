<?php

namespace LaravelRBAC\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

trait HasRoleAndPermission
{
    /**
     * Property for caching roles.
     *
     * @var \Illuminate\Database\Eloquent\Collection|null
     */
    protected $roles;

    /**
     * Property for caching permissions.
     *
     * @var \Illuminate\Database\Eloquent\Collection|null
     */
    protected $permissions;

    /**
     * User belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        $relation = config('laravelrbac.tables.role_user');

        return $this->belongsToMany(config('laravelrbac.models.role'), $relation['table_name'], $relation['fields']['user_id']['column'], $relation['fields']['role_id']['column']);
    }

    /**
     * Get all roles as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRoles()
    {
        if (!$this->roles){
            $this->roles = $this->roles()->get();
        }

        return $this->roles;
    }

    /**
     * Check if the user has role.
     *
     * @param int|string $role
     * @return bool
     */
    protected function hasRole($role)
    {
        $relation = $relation = config('laravelrbac.tables.role');

        return $this->getRoles()->contains(function ($value, $key) use ($role, $relation) {
            return $role == $value->{$relation['fields']['id']['column']} || Str::is($role, $value->{$relation['fields']['slug']['column']});
        });
    }

    /**
     * Get all permissions as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPermissions()
    {
        $permissions = new Collection();
        foreach ($this->getRoles() as $role) {
            $permissions = $permissions->merge($role->permissions);
        }

        return $permissions;
    }

    /**
     * Check if the user has a permission.
     *
     * @param int|string $permission
     * @return bool
     */
    protected function hasPermission($permission)
    {
        $relation = $relation = config('laravelrbac.tables.permission');

        return $this->getPermissions()->contains(function ($value, $key) use ($permission, $relation) {
            return $permission == $value->{$relation['fields']['id']['column']} || Str::is($permission, $value->{$relation['fields']['slug']['column']});
        });
    }

    /**
     * Sync roles to a user
     * @param array $roles
     * @return array
     */
    public function syncRoles($roles)
    {
        return $this->roles()->sync($roles);
    }

    /**
     * Get an array from argument.
     *
     * @param int|string|array $argument
     * @return array
     */
    protected function getArray($argument)
    {
        return (!is_array($argument)) ? preg_split('/ ?[,|] ?/', $argument) : $argument;
    }

    /**
     * Get method name.
     *
     * @param string $methodName
     * @param bool $all
     * @return string
     */
    protected function getMethodName($methodName, $all)
    {
        return ((bool) $all) ? $methodName . 'All' : $methodName . 'One';
    }

    /**
     * Check if the user has a role or roles.
     *
     * @param int|string|array $roles
     * @param bool $all
     * @return bool
     */
    public function is($roles, $all = false)
    {
        $this->{$this->getMethodName('is', $all)}($this->getArray($roles));
    }

    /**
     * Check if the user has at least one role.
     *
     * @param int|string|array $roles
     * @return bool
     */
    public function isOne($roles)
    {
        $roles = $this->getArray($roles);
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user has all roles.
     *
     * @param int|string|array $roles
     * @return bool
     */
    public function isAll($roles)
    {
        $roles = $this->getArray($roles);
        foreach ($roles as $role) {
            if (!$this->hasRole($role)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if the user has a permission or permissions.
     *
     * @param int|string|array $permissions
     * @param bool $all
     * @return bool
     */
    public function can($permissions, $all = false)
    {
        return $this->{$this->getMethodName('can', $all)}($this->getArray($permissions));
    }

    /**
     * Check if the user has at least one permission.
     *
     * @param int|string|array $permissions
     * @return bool
     */
    protected function canOne($permissions)
    {
        $permissions = $this->getArray($permissions);
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user has all permissions.
     *
     * @param int|string|array $permissions
     * @return bool
     */
    protected function canAll($permissions)
    {
        $permissions = $this->getArray($permissions);
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }

        return true;
    }
}
