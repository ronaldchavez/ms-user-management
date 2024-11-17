<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, HasRoles, HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'age', 'birth_date', 
        'gender', 'dni', 'address', 'country', 'phone', 'role_id'
    ];

    protected $hidden = ['password'];
}
