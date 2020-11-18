<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

class RoleHasPermissionService
{
    private $roleHasPermission;

    public function __construct(Role $roleHasPermission)
    {
        $this->roleHasPermission = $roleHasPermission;
    }

    public function getRolePermission($request)
    {
        $query = $this->roleHasPermission->query();

        $result = $query->with('permissions')
        ->when($request->q, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->q}%")
            ->orWhere('guard_name', 'like', "%{$request->q}%");
        })->paginate(20);
        $result->appends($request->only('q'));

        return $result;
    }

    public function getTotalRolePermission($request)
    {
        $query = $this->roleHasPermission->query();

        $result = $query->with('permissions')
                        ->when($request->q, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->q}%")
            ->orWhere('guard_name', 'like', "%{$request->q}%");
        })->count();

        return $result;
    }
}