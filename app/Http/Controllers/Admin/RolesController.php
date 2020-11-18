<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RolesRequest;
use App\Services\RolesService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    private $service;

    public function __construct(RolesService $service)
    {
        $this->service = $service;
    } 

    public function index(Request $request)
    {
        $data['title'] = 'Roles';
        $data['roles'] = $this->service->getRoles($request);
        $data['total'] = $this->service->getTotalRoles($request);
        
        return view('backend.roles.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = 'Create';
        $data['type'] = strtolower($data['title']);

        return view('backend.roles.form', compact('data'));
    }

    public function store(RolesRequest $request)
    {

        try {
            
            $roles = new Role($request->all());
            $roles->create([
                'name' => $request->name,
                'guard_name' => 'web',
            ]);
            return redirect('roles')->with('success' , 'Add roles successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('failed' , $th->getMessage());
        }

    }

    public function edit($id)
    {
        $data['title'] = 'Edit';
        $data['type'] = strtolower($data['title']);
        $data['roles'] = $this->service->getRolesById($id);

        return view('backend.roles.form', compact('data'));
    }

    public function update(RolesRequest $request, $id)
    {
        try {
            
            $roles = $this->service->getRolesById($id);
            $roles->fill([
                'name' => $request->name,
            ]);
            $roles->save();

            return redirect('roles')->with('success' , 'Edit roles successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('failed' , $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            
            $roles = $this->service->getRolesById($id);
            $roles->delete();

            return redirect('roles')->with('success' , 'Edit roles successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('failed' , $th->getMessage());
        }
    }
}
