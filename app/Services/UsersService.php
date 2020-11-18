<?php

namespace App\Services;

use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersService
{
    private $users;

    public function __construct(User $users)
    {
        $this->users = $users;
    }

    public function getAll(){
        return $this->users->all();
    }


    public function getUsers($request)
    {
        $query = $this->users->query();

        $result = $query->with('roles')->orderBy('id', 'ASC')
                        ->when($request->q, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->q}%")
            ->orWhere('email', 'like', "%{$request->q}%")
            ->orWhere('username', 'like', "%{$request->q}%");
        })->when($request->r, function ($query) use ($request) {
            return $query->whereHas('roles', function ($query) use ($request) {
                $query->where('name', $request->r);
            });
        })->when($request->s, function ($query) use ($request) {
            return $query->where('active', $request->s);
        })->paginate(20);
        $result->appends($request->only('q'));

        return $result;
    }

    public function getTotalUsers($request)
    {
        $query = $this->users->query();

        $result = $query->with('roles')->orderBy('id', 'ASC')
                         ->when($request->q, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->q}%")
            ->orWhere('email', 'like', "%{$request->q}%")
            ->orWhere('username', 'like', "%{$request->q}%");
        })->count();

        return $result;
    }

    public function getUserById($id)
    {
        $query = $this->users->query();

        $result = $query->findOrFail($id);

        return $result;
    }
    public function store($request)
    {
        $users =  $this->users->create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $users->assignRole($request->roles);
        $users->save();
    }

    
    
}