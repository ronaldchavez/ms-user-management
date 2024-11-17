<?php

namespace App\Services;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class PermissionsService
{
    protected $userRepo;

    public function __construct(){}

    public function getPermissionsUsers(string $name)
    {
        
        $user = auth()->user();
        $role = $user->roles->first();

        if ($role && !$role->hasPermissionTo($name)) {
           return false;
        } 

        return true;
    }

}
