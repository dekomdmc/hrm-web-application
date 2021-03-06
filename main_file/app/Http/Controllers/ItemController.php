<?php

namespace App\Http\Controllers;

use App\Category;
use App\Exports\ItemsExport;
use App\Imports\ItemsImport;
use App\Item;
use App\TaxRate;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    public function index()
    {
        if (\Auth::user()->type == 'company' || \Auth::user()->hasPermissionTo('view stock')) {
            $items = Item::where('created_by', '=', \Auth::user()->creatorId())->where('is_mode', 'stock')->get();
            return view('item.index', compact('items'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function bulkdelete(Request $req)
    {
        if (Auth::user()->type == 'company') {
            $item_ids = json_decode($req->item_ids);
            if (Item::destroy($item_ids)) {
            }
        }
    }

    public function create()
    {
        $category = Category::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 0)->get()->pluck('name', 'id');
        $category->prepend('Select Category');
        $unit = Unit::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $unit->prepend('Select Unit', '');
        $tax = TaxRate::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');


        return view('item.create', compact('category', 'unit', 'tax'));
    }

    public function prices()
    {
        $items = Item::where('created_by', '=', \Auth::user()->creatorId())->where('is_mode', '=', null)->get();
        return view('item.prices', compact('items'));
    }

    public function createStockItem()
    {
        $category = Category::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 0)->get()->pluck('name', 'id');
        $category->prepend('Select Category');
        $unit = Unit::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $unit->prepend('Select Unit', '');
        $tax = TaxRate::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        return view('item.createStockItem', compact('category', 'unit', 'tax'));
    }

    public function pricesStore(Request $request)
    {
        if (\Auth::user()->type == 'company' || \Auth::user()->hasPermissionTo('edit product')) {
            $rules = [
                'name' => 'required',
                'sku' => 'required',
                'sale_price' => 'required|numeric',
                'purchase_price' => 'required|numeric',
                'tax' => 'required',
                'category' => 'required',
                'unit' => 'required',
                'type' => 'required',
            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->route('item.index')->with('error', $messages->first());
            }

            $item                 = new \App\StockItem();
            $item->name           = $request->name;
            $item->description    = $request->description;
            $item->sku            = $request->sku;
            $item->sale_price     = $request->sale_price;
            $item->purchase_price = $request->purchase_price;
            $item->tax            = implode(',', $request->tax);
            $item->unit           = $request->unit;
            $item->type           = $request->type;
            $item->category       = $request->category;
            $item->created_by     = \Auth::user()->creatorId();
            $item->save();

            return redirect()->route('item.prices')->with('success', __('Item successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function importStockItemExcel()
    {
        if (request()->file('excelfile')->isValid()) {
            $items = (new \App\Imports\StockItemsImport)->toArray(request()->file('excelfile'));
            if (count($items) > 0) {
                foreach ($items as $items_) {
                    if (count($items_) > 0) {
                        \App\Item::where('is_mode', '=', null)->delete();
                        foreach ($items_ as $item) {
                            if ($item[0] != 'NAME') {
                                $arr = [
                                    'name' => $item[0],
                                    'sku' => $item[1],
                                    'sale_price' => $item[2] == "" ? 0.00 : $item[2],
                                    'purchase_price' => $item[3] == "" ? 0.00 : $item[3],
                                    'quantity' => $item[4],
                                    'tax' => $item[5],
                                    'category' => (new Item)->getCategoryIdByName($item[6]),
                                    'unit' => (new Item)->getUnitIdByName($item[7]),
                                    'type' => $item[8],
                                    'description' => $item[9] == "" ? "No Description" : $item[9],
                                    'created_by' => Auth::user()->id
                                ];
                                \App\Item::create($arr);
                            }
                        }
                    }
                    // Excel::import(new \App\Imports\ItemsImport, request()->file('excelfile'));
                }
            }
        }
    }

    public function importExcel()
    {
        if (request()->file('excelfile')->isValid()) {
            $items = (new ItemsImport)->toArray(request()->file('excelfile'));
            if (count($items) > 0) {
                foreach ($items as $items_) {
                    if (count($items_) > 0) {
                        Item::where("is_mode", "=", "stock")->delete();
                        foreach ($items_ as $item) {
                            if ($item[0] != 'NAME') {
                                $arr = [
                                    'name' => $item[0],
                                    'sku' => $item[1],
                                    'sale_price' => $item[2] == "" ? 0.00 : $item[2],
                                    'purchase_price' => $item[3] == "" ? 0.00 : $item[3],
                                    'quantity' => $item[4],
                                    'tax' => $item[5],
                                    'category' => (new Item)->getCategoryIdByName($item[6]),
                                    'unit' => (new Item)->getUnitIdByName($item[7]),
                                    'type' => $item[8],
                                    'is_mode' => $item[8] == "product" ? 'stock' : null,
                                    'description' => $item[9] == "" ? "No Description" : $item[9],
                                    'created_by' => Auth::user()->id
                                ];
                                Item::create($arr);
                            }
                        }
                    }
                    // Excel::import(new \App\Imports\ItemsImport, request()->file('excelfile'));
                }
            }
        }
    }

    public function exportExcel()
    {
        return (new ItemsExport)->download('PriceItem.xlsx');
    }

    public function createStockItemExport()
    {
        return (new \App\Exports\StockItemsExport)->download('StockItem.xlsx');
    }


    public function store(Request $request)
    {
        if (\Auth::user()->type == 'company' || \Auth::user()->hasPermissionTo('create product')) {
            $rules = [
                'name' => 'required',
                'sku' => 'required',
                'sale_price' => 'required|numeric',
                'purchase_price' => 'required|numeric',
                'tax' => 'required',
                'category' => 'required',
                'unit' => 'required',
                'type' => 'required',
            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->route('item.index')->with('error', $messages->first());
            }

            $item                 = new Item();
            if (isset($request->is_mode)) {
                $item->is_mode = $request->is_mode;
            }
            $item->name           = $request->name;
            $item->description    = $request->description;
            $item->sku            = $request->sku;
            $item->sale_price     = $request->sale_price;
            $item->purchase_price = $request->purchase_price;
            $item->tax            = implode(',', $request->tax);
            $item->unit           = $request->unit;
            $item->type           = $request->type;
            $item->category       = $request->category;
            $item->created_by     = \Auth::user()->creatorId();
            $item->save();
            if (isset($request->is_mode)) {
                return redirect()->route('item.index')->with('success', __('Item successfully created.'));
            } else {
                return redirect()->route('item.prices')->with('success', __('Item successfully created.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(Item $item)
    {
        //
    }


    public function edit(Item $item)
    {
        $category = Category::where('created_by', '=', \Auth::user()->creatorId())->where('type', '=', 0)->get()->pluck('name', 'id');
        $category->prepend('Select Category');
        $unit = Unit::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $unit->prepend('Select Unit');
        $tax = TaxRate::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

        $item->tax = explode(',', $item->tax);

        return view('item.edit', compact('category', 'unit', 'tax', 'item'));
    }


    public function update(Request $request, Item $item)
    {
        if (\Auth::user()->type == 'company' || \Auth::user()->hasPermissionTo('edit product')) {
            $rules = [
                'name' => 'required',
                'sku' => 'required',
                'sale_price' => 'required|numeric',
                'purchase_price' => 'required|numeric',
                'tax' => 'required',
                'category' => 'required',
                'unit' => 'required',
                'type' => 'required',
            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->route('item.index')->with('error', $messages->first());
            }


            $item->name           = $request->name;
            $item->description    = $request->description;
            $item->sku            = $request->sku;
            $item->sale_price     = $request->sale_price;
            $item->purchase_price = $request->purchase_price;
            $item->tax            = implode(',', $request->tax);
            $item->unit           = $request->unit;
            $item->type           = $request->type;
            $item->quantity           = $request->quantity;
            $item->category       = $request->category;
            $item->save();
            if ($item->is_mode != null) {
                return redirect()->route('item.index')->with('success', __('Item successfully updated.'));
            } else {
                return redirect()->route('item.prices')->with('success', __('Item successfully updated.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(Item $item)
    {
        if (\Auth::user()->type == 'company' || \Auth::user()->hasPermissionTo('edit product')) {
            if ($item->is_mode != null) {
                $item->delete();
                return redirect()->route('item.index')->with('success', __('Item successfully deleted.'));
            } else {
                $item->delete();
                return redirect()->route('item.prices')->with('success', __('Item successfully deleted.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroyItem(\App\StockItem $item)
    {
        if (\Auth::user()->type == 'company' || \Auth::user()->hasPermissionTo('edit product')) {
            return redirect()->route('item.prices')->with('success', __('Item successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
