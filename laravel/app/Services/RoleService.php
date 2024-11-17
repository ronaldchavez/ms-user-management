<?php

namespace App\Services;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class RoleService
{
    protected $userRepo;

    public function __construct(){}

    public function getExistRol(string $name)
    { 
        try {
            $role = Role::findByName($name);
            return $role;
        } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
            return false;
        }
    }

}
