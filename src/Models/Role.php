<?php

namespace LaravelRBAC\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelRBAC\Traits\HasConnection;
use LaravelRBAC\Traits\HasUserAndPermission;

class Role extends Model
{
    use HasConnection;
    use HasUserAndPermission;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admin_permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description'];

    /**
     * Create a new model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->resetConnection();
    }
}
