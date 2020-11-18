<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    private $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $data['title'] = 'Permission';
        $data['permission'] = $this->service->getPermission($request);
        $data['total'] = $this->service->getTotalPermission($request);

        return view('backend.permission.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = 'Create';
        $data['type'] = strtolower($data['title']);

        return view('backend.permission.form', compact('data'));
    }

    public function store(PermissionRequest $request)
    {

            $permission = new Permission($request->all());
            $permission->fill([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);
            $permission->save();

            return redirect('permission')->with('success' , 'Add permission successfully');

    }

    public function edit($id)
    {
        $data['title'] = 'Edit';
        $data['type'] = strtolower($data['title']);
        $data['permission'] = $this->service->getPermissionById($id);

        return view('backend.permission.form', compact('data'));
    }

    public function update(PermissionRequest $request, $id)
    {
        try {
            
            $permission = $this->service->getPermissionById($id);
            $permission->fill([
                'name' => $request->name,
            ]);
            $permission->save();

            return redirect('permission')->with('success' , 'Edit permission successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('failed' , $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            
            $permission = $this->service->getPermissionById($id);
            $permission->delete();

            return redirect('permission')->with('success' , 'Edit permission successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('failed' , $th->getMessage());
        }
    }
}
