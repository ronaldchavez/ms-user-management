<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Services\RoleService;
use App\Services\PermissionsService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Rules\CountryRule;
use App\Helpers\Helpers;


class UserController extends Controller
{
    protected $userService;
    protected $roleService;
    protected $permissionsService;

    public function __construct(UserService $userService, RoleService $roleService, PermissionsService $permissionsService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->permissionsService = $permissionsService;
    }

    public function index()
    {
        if(!$this->permissionsService->getPermissionsUsers('list_user')){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized',
                'data' => []
            ], 403);
        }

        $users = response()->json($this->userService->getAllUsers());

        return response()->json([
            'success' => true,
            'message' => 'Users consulted successfully',
            'data' => $users
        ], 200);

    }

    public function show(int $id)
    {

        if(!$this->permissionsService->getPermissionsUsers('view_user')){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized',
            ], 403);
        }

        $user = response()->json($this->userService->getUser($id));
        
        return response()->json([
            'success' => true,
            'message' => 'User consulted successfully',
            'data' => $user
        ], 200);
    }

    public function store(Request $request)
    {
        if(!$this->permissionsService->getPermissionsUsers('create_user')){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized',
                'data' => []
            ], 403);
        }

        $user = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'birth_date' => 'required|date|date_format:Y-m-d|before:-18 years',
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'dni' => 'required|string|max:20|unique:users,dni',
            'address' => 'nullable|string|max:255',
            'country' => ['required', new CountryRule],
            'phone' => 'required|string|max:20|regex:/^[0-9\s\-\+\(\)]+$/',
            'role' => 'required|string|max:255'
        ]);

        if(!$this->roleService->getExistRol($request->role)){
            return response()->json([
                'success' => false,
                'message' => 'Role not found',
                'data' => []
            ], 400);
        }

        $user['age'] = Helpers::calculateAge($request->birth_date);
        $user['password'] = Hash::make($request->password);

        $user = $this->userService->createUser($user);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], 200);

    }

    public function update(Request $request, $id)
    {

        if(!$this->permissionsService->getPermissionsUsers('update_user')){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized',
            ], 403);
        }
        
        $user = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|string|min:8',
            'birth_date' => 'required|date|date_format:Y-m-d|before:-18 years',
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'dni' => 'required|string|max:20|unique:users,dni,' . $id,
            'address' => 'nullable|string|max:255',
            'country' => ['required', new CountryRule],
            'phone' => 'required|string|max:20|regex:/^[0-9\s\-\+\(\)]+$/',
            'role' => 'required|string|max:255'
        ]);

        if(!$this->roleService->getExistRol($request->role)){
            return response()->json([
                'success' => false,
                'message' => 'Role not found',
                'data' => []
            ], 400);
        }

        $user = $this->userService->updateUser($id, $user);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => $user
        ], 200);
    }

    public function destroy($id)
    {
        if(!$this->permissionsService->getPermissionsUsers('delete_user')){
            return response()->json([
                'success' => false,
                'message' => 'unauthorized',
            ], 403);
        }

        $this->userService->deleteUser($id);

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
            'data' => $user
        ], 200);
    }
}
