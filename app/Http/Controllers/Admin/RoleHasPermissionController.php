<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleHasPermissionRequest;
use App\Services\PermissionService;
use App\Services\RoleHasPermissionService;
use App\Services\RolesService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionController extends Controller
{
    private $service, $serviceRoles, $servicePermission;

    public function __construct(
        RoleHasPermissionService $service, 
        RolesService $serviceRoles, 
        PermissionService $servicePermission)
    {
        $this->service = $service;
        $this->serviceRoles = $serviceRoles;
        $this->servicePermission = $servicePermission;
    }

    public function index(Request $request)
    {
        $data['title'] = 'Role Has Permission';
        $data['role_has_permission'] = $this->service->getRolePermission($request);
        $data['permission'] = ['Users', 'Pages', 'Section', 'Category', 'Post'];
        $data['total'] = $this->service->getTotalRolePermission($request);

        return view('backend.role-has-permission.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = 'Create';
        $data['type'] = strtolower($data['title']);
        $data['roles'] = Role::all();
        $data['permission'] = Permission::all();

        return view('backend.role-has-permission.form', compact('data'));
    }

    public function store(RoleHasPermissionRequest $request)
    {
        try {
            
            $this->validate($request, [
                'role_id' => 'required',
            ]);

            $role = $this->serviceRoles->getRolesById($request->role_id);
            $role->givePermissionTo($request->permission);

            return redirect('role-has-permission')->with('success' ,
                 'Add role permission successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('failed' , $th->getMessage());
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit';
        $data['type'] = strtolower($data['title']);
        $data['roles'] = $this->serviceRoles->getRolesById($id);
        $collectRoles = collect($data['roles']['permissions']);
        $data['permission_id'] = $collectRoles->map(function($item, $key) {
            return $item['id'];
        })->all();

        $data['permission'] = Permission::all();

        return view('backend.role-has-permission.form', compact('data'));
    }

    public function update(RoleHasPermissionRequest $request)
    {
        try {
            
            $this->validate($request, [
                'role_id' => 'required',
            ]);

            $role = $this->serviceRoles->getRolesById($request->role_id);
            $role->syncPermissions($request->permission);

            return redirect('role-has-permission')->with('success' ,
                'Add role permission successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('failed' , $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            $role = $this->serviceRoles->getRolesById($id);
            $role->delete();

            return redirect('role-has-permission')->with('success' ,
                 'Add role permission successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('failed' , $th->getMessage());
        }
    }
}
