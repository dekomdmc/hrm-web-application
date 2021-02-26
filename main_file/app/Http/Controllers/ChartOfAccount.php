<?php

namespace App\Http\Controllers;

use App\ChartOfAccount as AppChartOfAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChartOfAccount extends Controller
{
    function index()
    {
        if (\Auth::user()->type == "company" || \Auth::user()->type == 'employee') {
            $chartofaccounts = \App\ChartOfAccount::query()->get()->toArray();
            return view("chartofaccount.index", compact("chartofaccounts"));
        }
    }

    function getGroupName($id)
    {
        $coag = \App\ChartOfAccountGroup::query()->where(["id" => $id])->get()->toArray();
        return $coag[0]['name'];
    }

    function delete($id)
    {
        if (\Auth::user()->type == 'company') {
            $coa = \App\ChartOfAccount::query()->where(["id" => $id])->delete();
            return redirect()->route("chartofaccount.index")->with("success", __("Data deleted successfully"));
        }
    }

    function create()
    {
        $groups = \App\ChartOfAccountGroup::query()->where("created_by", Auth::user()->id)->get()->toArray();
        return view("chartofaccount.create", compact("groups"));
    }

    function edit(\App\ChartOfAccount $chartofaccount)
    {
        $groups = \App\ChartOfAccountGroup::query()->where("created_by", Auth::user()->id)->get()->toArray();
        return view("chartofaccount.edit", compact("chartofaccount", "groups"));
    }

    public function store(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'group_id' => 'required'
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $chartofaccount = new \App\ChartOfAccount();
            $chartofaccount->name = $request->name;
            $chartofaccount->group_id = $request->group_id;
            $chartofaccount->created_by = \Auth::user()->id;
            $chartofaccount->save();

            return redirect()->route('chartofaccount.index')->with('success', __('Successfully created.'));
        }
    }

    public function update(Request $request, \App\ChartOfAccount $chartofaccount)
    {
        if (Auth::user()->type == 'company') {
            $validator = Validator::make(
                $request->all(),
                [

                    'name' => 'required',
                    'group_id' => 'required'
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $chartofaccount->group_id = $request->group_id;
            $chartofaccount->name = $request->name;
            $chartofaccount->save();

            return redirect()->route('chartofaccount.index')->with('success', __('Chart Of Account successfully updated.'));
        }
    }
}
