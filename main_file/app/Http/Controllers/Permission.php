<?php

namespace App\Http\Controllers;

use App\Resignation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Permission extends Controller
{
    public function index(){
        return view('permission.index');
    }

    public function edit(){}

    public function delete(){}

    public function store(){}
}
