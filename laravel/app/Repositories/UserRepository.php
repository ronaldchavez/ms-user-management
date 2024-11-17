<?php

namespace App\Repositories;
use Spatie\Permission\Models\Role;

use App\Models\User;

class UserRepository
{
    public function getAll()
    {
        return User::with('roles', 'permissions')->get();
    }

    public function findById($id)
    {
        return User::with('roles', 'permissions')->find($id);
    }

    public function create(array $data)
    {
        try {
            $user = User::create($data);
            $role = Role::findByName('admin', 'sanctum'); // Asegúrate de que el guard es 'sanctum'

            $user = auth()->user(); // Obtener el usuario autenticado
            $user->assignRole($role); // Asignar el rol
        
        return $user;
        } catch (\Throwable $th) {
            print_r($th->getMessage());
        }
        
    }

    public function update($id, array $data)
    {
        $user = $this->findById($id);
        
        if(!$user){
            return false;
        }

        $user->update($data);
        $user->assignRole($data['role']);
        return $user;
    }

    public function delete($id)
    {
        $user = $this->findById($id);

        if(!$user){
            return false;
        }

        return $user->delete();
    }
}
