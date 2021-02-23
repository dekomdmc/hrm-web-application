<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChartOfAccountGroup extends Controller
{
    public function create()
    {
        return view("chartofaccountgroup.create");
    }

    public function store(Request $request)
    {
        if (Auth::user()->type == 'company') {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $chartofaccount = new \App\ChartOfAccountGroup();
            $chartofaccount->name = $request->name;
            $chartofaccount->created_by = Auth::user()->id;
            $chartofaccount->save();

            return redirect()->route('chartofaccount.index')->with('success', __('Successfully created.'));
        }
    }
}
