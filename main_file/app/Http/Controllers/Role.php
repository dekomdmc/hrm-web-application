<?php

namespace App\Http\Controllers;

use App\Resignation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role extends Controller
{
    public function index(){
        $roles = \App\Role::query()->get();
        return view('role.index', compact('roles'));
    }
    
    public function create(){
        return view('role.create');
    }

    public function edit(\App\Role $role){}

    public function destroy(\App\Role $role){
        $role->delete();
        return redirect()->back()->with('success', __('Role successfully deleted.'));
    }

    public function permission(\App\Role $role){
        return view("permission.index");
    }

    public function store(Request $request){
        if(Auth::user()->type == "company"){
            $role = new \App\Role();
            $role->name = $request->name;
            $role->created_by = Auth::user()->id;
            $role->save();
            return redirect()->back();
        }
    }

}
