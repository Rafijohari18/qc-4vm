<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;

class PermissionService
{
    private $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function getPermission($request)
    {
        $query = $this->permission->query();

        $result = $query->orderBy('id', 'ASC')
                        ->when($request->q, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->q}%")
            ->orWhere('guard_name', 'like', "%{$request->q}%");
        })->paginate(20);
        $result->appends($request->only('q'));

        return $result;
    }

    public function getTotalPermission($request)
    {
        $query = $this->permission->query();

        $result = $query->orderBy('id', 'ASC')
                        ->when($request->q, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->q}%")
            ->orWhere('guard_name', 'like', "%{$request->q}%");
        })->count();

        return $result;
    }
    
    public function getPermissionById($id)
    {
        $query = $this->permission->query();

        $result = $query->findOrFail($id);

        return $result;
    }
}