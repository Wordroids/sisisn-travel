<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('pages.role-permissions.index', compact('roles', 'permissions'));
    }

    public function updatePermissions(Request $request)
    {
        $role = Role::findById($request->role_id);
        
        // Convert permission IDs to names if permissions were selected
        $permissionNames = [];
        if ($request->has('permissions')) {
            $permissionNames = Permission::whereIn('id', $request->permissions)
                                      ->pluck('name')
                                      ->toArray();
        }
        
        $role->syncPermissions($permissionNames);
        
        return redirect()->back()->with('success', 'Permissions updated successfully');
    }
}