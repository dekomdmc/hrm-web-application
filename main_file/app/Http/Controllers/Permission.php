<?php

namespace App\Http\Controllers;

use App\Resignation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Permission extends Controller
{
    public function index($id){
        $user = \App\User::find($id);
        $permissions = \App\Permission::query()->get();
        return view('permission.index', compact('user', 'permissions'));
    }

    public function createPermission(int $id){
        // $permissions = $_POST

        if(Auth::user()->type == "company"){
            $permissions = request('permissions');
            $user = \App\User::find($id);
            foreach ($permissions as $permission) {
                $perm = \App\Permission::find($permission);
                $user->givePermissionTo($perm->name);
            }
            return redirect()->back()->with('success', 'Successfully created');
        }

    }

    public function edit(){}

    public function delete(){}

    public function create(){
        return view("permission.create");
    }

    public function store(Request $request){
        if(Auth::user()->type == "company"){
            \Spatie\Permission\Models\Permission::create(['name' => $request->name]);
            return redirect()->back()->with('success', 'Successfully created');
        }
    }
}
