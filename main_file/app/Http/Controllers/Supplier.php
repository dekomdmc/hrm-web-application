<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Supplier extends Controller
{
    public function index()
    {
            $suppliers = \App\Supplier::query()->get()->toArray();
            return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        if (\Auth::user()->type == "company") {
            return view('supplier.create');
        }
    }

    public function edit(\App\Supplier $supplier)
    {
        $asset = \App\Supplier::find($supplier);

        return view('supplier.edit', compact('asset'));
    }

    function delete($id)
    {
        if (\Auth::user()->type == 'company') {
            \App\Supplier::query()->where(["id" => $id])->delete();
            return redirect()->route("supplier.index")->with("success", __("Data deleted successfully"));
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            $validator = \Validator::make(
                $request->all(),
                [
                    'company_name' => 'required',
                    'mobile' => 'required',
                    'address' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $supplier = new \App\Supplier();
            $supplier->user_id = \Auth::user()->id;
            $supplier->company_name = $request->company_name;
            $supplier->mobile = $request->mobile;
            $supplier->address = $request->address;
            $supplier->created_by = \Auth::user()->creatorId();
            $supplier->save();
            return redirect()->route('supplier.index')->with('success', __('Successfully created.'));
        }
    }
}
