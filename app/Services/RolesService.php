<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

class RolesService
{
    private $roles;

    public function __construct(Role $roles)
    {
        $this->roles = $roles;
    }

    public function getRoles($request)
    {
        $query = $this->roles->query();

        $result = $query->orderBy('id', 'ASC')
                        ->when($request->q, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->q}%")
            ->orWhere('guard_name', 'like', "%{$request->q}%");
        })->paginate(20);
        $result->appends($request->only('q'));

        return $result;
    }

    public function getTotalRoles($request)
    {
        $query = $this->roles->query();

        $result = $query->orderBy('id', 'ASC')
                        ->when($request->q, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->q}%")
            ->orWhere('guard_name', 'like', "%{$request->q}%");
        })->count();

        return $result;
    }
    
    public function getRolesById($id)
    {
        $query = $this->roles->query();

        $result = $query->with('permissions')->findOrFail($id);

        return $result;
    }
}