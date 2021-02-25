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
            $all_permissions = \App\Permission::query()->get();
            foreach ($all_permissions as $perm) {
                if($user->hasPermissionTo($perm->name)) {
                    $user->revokePermissionTo($perm->name);
                }
            }
            if(!empty($permissions)){
                foreach ($permissions as $permission) {
                    $perm = \App\Permission::find($permission);
                    $user->givePermissionTo($perm->name);
                }
                return redirect()->back()->with('success', 'Successfully created');
            }else{
                return redirect()->back()->with('warning', 'No permissions were granted');
            }
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
