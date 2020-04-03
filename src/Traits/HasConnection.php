<?php

namespace LaravelRBAC\Traits;

trait HasConnection
{
    public function resetConnection()
    {
        if ($connection = config('laravelrbac.connection')) {
            $this->connection = $connection;
        }
    }
}
