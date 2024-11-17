<?php

namespace App\Http\Controllers;

use App\Services\PermissionsService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Helpers\Helpers;


class RoleController extends Controller
{
    protected $permissionsService;

    public function __construct(PermissionsService $permissionsService)
    {
        $this->permissionsService = $permissionsService;
    }

    public function index()
    {
        $roles = Role::all();

        return response()->json([
            'success' => true,
            'message' => 'Roles consulted successfully',
            'data' => $roles
        ], 200);

    }

    public function show(int $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Role consulted successfully',
            'data' => $role
        ], 200);
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => [  'required',
                                'array',
                                Rule::in(['list_user', 'view_user', 'create_user', 'update_user', 'delete_user'])
                            ]
        ]);

        $adminRole = Role::create(['name' => $request->name, 'guard_name' => 'sanctum']);
        $adminRole->givePermissionTo($request->permissions);

        return response()->json([
            'success' => true,
            'message' => 'Role created successfully',
            'data' => $adminRole
        ], 200);

    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name'
        ]);
        
        $role = Role::findOrFail($id);
        $role->syncPermissions($validated['permissions']);

        return response()->json([
            'success' => true,
            'message' => 'Permissions updated successfully',
            'data' => $role->permissions
        ], 200);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        return response()->json([
            'success' => $role->users()->exists(),
            'message' => 'Role deleted successfully.',
        ]);
        if ($role->users()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'The role cannot be deleted because it has associated users.',
            ], 400);
        }

        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully.',
        ]);
    }

}
