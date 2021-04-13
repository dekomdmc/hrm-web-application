<?php

namespace App\Http\Controllers;

use App\Supplier;
use App\TaxRate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Item;
use App\User;
use App\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class PurchaseInvoice extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->type == 'client') {
            $invoices = \App\PurchaseInvoice::where('client', Auth::user()->id);
        } else {
            $invoices = \App\PurchaseInvoice::where('created_by', Auth::user()->creatorId());
        }

        if (!empty($request->status)) {
            $invoices->where('status', $request->status);
        }

        if (!empty($request->start_date)) {
            $invoices->where('issue_date', '>=', $request->start_date);
        }

        if (!empty($request->end_date)) {
            $invoices->where('due_date', '<=', $request->end_date);
        }

        $invoices = $invoices->get();

        $status = \App\PurchaseInvoice::$statues;
        return view('purchaseinvoice.index', compact('invoices', 'status'));
    }

    public function invoiceNumber()
    {
        $latest = \App\PurchaseInvoice::where('created_by', '=', Auth::user()->creatorId())->latest()->first();
        if (!$latest) {
            return 1;
        }

        return $latest->invoice_id + 1;
    }

    public function getClientProject(Request $request)
    {
        $projects = \App\Project::where('client', $request->client_id)->get()->pluck('title', 'id');

        return response()->json($projects);
    }

    public function store(Request $request)
    {
        // if (Auth::user()->type == 'company' || \Auth::user()->hasPermissionTo('view stock')) {
        $validator = Validator::make(
            $request->all(),
            [
                    'issue_date' => 'required',
                    'due_date' => 'required',
                    'client' => 'required',
                ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $invoice              = new \App\PurchaseInvoice();
        $invoice->invoice_id  = $this->invoiceNumber();
        $invoice->issue_date  = $request->issue_date;
        $invoice->due_date    = $request->due_date;
        $invoice->client      = $request->client;
        $invoice->chart_of_account = $request->chart_of_account;
        $invoice->project     = ($request->type == 'Project') ? $request->project : 0;
        $invoice->tax         = ($request->type == 'Project') ? !empty($request->tax) ? implode(',', $request->tax) : '' : '';
        $invoice->type        = $request->type;
        $invoice->status      = 1;
        $invoice->description = $request->description;
        $invoice->created_by  = Auth::user()->creatorId();
        $invoice->save();

        return redirect()->route('purchaseinvoice.show', Crypt::encrypt($invoice->id))->with('success', 'Invoice successfully created.');
        // } else {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
    }

    public function pdf($id)
    {
        $settings = Utility::settings();

        $invoice   = \App\PurchaseInvoice::where('id', $id)->first();
        $data  = \DB::table('settings');
        $data  = $data->where('created_by', '=', $invoice->created_by);
        $data1 = $data->get();

        foreach ($data1 as $row) {
            $settings[$row->name] = $row->value;
        }

        $client        = $invoice->clients;
        $items         = [];
        $totalTaxPrice = 0;
        $totalQuantity = 0;
        $totalRate     = 0;
        $totalDiscount = 0;
        $taxesData     = [];

        foreach ($invoice->items as $product) {
            $item           = new \stdClass();
            $item->name     = $product->item;
            $item->quantity = $product->quantity;
            $item->tax      = $product->tax;
            $item->discount = $product->discount;
            $item->price    = $product->price;

            $totalQuantity += $item->quantity;
            $totalRate     += $item->price;
            $totalDiscount += $item->discount;

            $taxes = \Utility::tax($item->tax);

            $itemTaxes = [];

            foreach ($taxes as $tax) {
                if (is_object($tax)) {
                    $taxPrice      = \Utility::taxRate($tax->rate, $item->price, $item->quantity);
                    $totalTaxPrice += $taxPrice;

                    $itemTax['name']  = $tax->name;
                    $itemTax['rate']  = $tax->rate . '%';
                    $itemTax['price'] = \App\Utility::priceFormat($settings, $taxPrice);
                    $itemTaxes[]      = $itemTax;


                    if (array_key_exists($tax->name, $taxesData)) {
                        $taxesData[$tax->name] = $taxesData[$tax->name] + $taxPrice;
                    } else {
                        $taxesData[$tax->name] = $taxPrice;
                    }
                }
            }

            $item->itemTax = $itemTaxes;
            $items[]       = $item;
        }

        $invoice->items         = $items;
        $invoice->totalTaxPrice = $totalTaxPrice;
        $invoice->totalQuantity = $totalQuantity;
        $invoice->totalRate     = $totalRate;
        $invoice->totalDiscount = $totalDiscount;
        $invoice->taxesData     = $taxesData;

        //Set your logo
        $logo         = asset(Storage::url('uploads/logo/'));
        $company_logo = Utility::getValByName('company_logo');
        $img          = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo.png'));

        if ($invoice) {
            $color      = '#' . $settings['invoice_color'];
            $font_color = Utility::getFontColor($color);

            return view('invoice.templates.' . $settings['invoice_template'], compact('invoice', 'color', 'settings', 'client', 'img', 'font_color'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function items(Request $request)
    {
        $items        = \App\Item::where('id', $request->item_id)->first();
        $items->taxes = $items->tax($items->tax);

        return json_encode($items);
    }

    public function edit(\App\PurchaseInvoice $invoice)
    {
        $clients = User::where('created_by', \Auth::user()->creatorId())->where('type', 'client')->get()->pluck('name', 'id');
        $clients->prepend('Select Client', '');
        $taxes        = TaxRate::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $invoice->tax = explode(',', $invoice->tax);

        return view('purchaseinvoice.edit', compact('clients', 'taxes', 'invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        if (\Auth::user()->type == 'company' || \Auth::user()->hasPermissionTo('view sales')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'issue_date' => 'required',
                    'due_date' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $invoice->issue_date  = $request->issue_date;
            $invoice->due_date    = $request->due_date;
            $invoice->description = $request->description;
            $invoice->save();

            return redirect()->route('invoice.index')->with('success', 'Invoice successfully updated.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function createItem($invoice_id)
    {
        $items = \App\Item::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $items->prepend('Select Item', '');

        $invoice = \App\PurchaseInvoice::find($invoice_id);

        if ($invoice->type == 'Project') {
            $milestons = !empty($invoice->projects) ? $invoice->projects->milestones->pluck('title', 'title') : '';
            $tasks     = !empty($invoice->projects) ? $invoice->projects->tasks->pluck('title', 'title') : '';
            $taxes     = \Utility::tax($invoice->tax);
        } else {
            $tasks = $milestons = $taxes = [];
        }

        return view('purchaseinvoice.createItem', compact('invoice', 'items', 'milestons', 'tasks', 'taxes'));
    }

    public function itemDelete($id, $item_id)
    {
        if (\Auth::user()->type == 'company' || \Auth::user()->hasPermissionTo('view stock')) {
            $invoice        = \App\PurchaseInvoice::find($id);
            $invoiceProduct = \App\PurchaseInvoiceProduct::find($item_id);
            $invoiceProduct->delete();
            //        if($invoice->getDue() <= 0.0)
            //        {
            //            Invoice::change_status($invoice->id, 3);
            //        }

            return redirect()->back()->with('success', __('Item successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function storeProduct(Request $request, $invoice_id)
    {
        if (\Auth::user()->type == 'company' || \Auth::user()->hasPermissionTo('view stock')) {
            $itemname = "";
            if ($request->custom_itemcheck == "on") {
                if (!empty($request->item_name)) {
                    $itemname = $request->item_name;
                }
            } else {
                if (!empty($request->item)) {
                    $itemname = Item::find($request->item)->name;
                }
            }

            if ($itemname == "") {
                return redirect()->back()->with('error', __('Item name cannot be empty'));
            }

            $validator = \Validator::make(
                $request->all(),
                [
                    'quantity' => 'required',
                    'price' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $invoiceProduct              = new \App\PurchaseInvoiceProduct();
            $invoiceProduct->invoice     = $invoice_id;
            $invoiceProduct->item        = $itemname;
            $invoiceProduct->quantity    = $request->quantity;
            $invoiceProduct->price       = $request->price;
            $invoiceProduct->discount    = $request->discount;
            $invoiceProduct->type        = __('product');
            $invoiceProduct->tax         = $request->tax;
            $invoiceProduct->description = $request->description;
            $invoiceProduct->save();

            return redirect()->back()->with('success', 'Invoice product successfully created.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function editInvoiceProduct(Request $request)
    {
        $purchase_invoice_product = \App\PurchaseInvoiceProduct::find($request->id);
        return view('purchaseinvoice.editInvoiceItem', compact('purchase_invoice_product'));
    }

    public function send($id)
    {
        $invoice = \App\PurchaseInvoice::find($id);
        if ($invoice->status == 0) {
            $invoice->send_date = date('Y-m-d');
            $invoice->status    = 1;
            $invoice->save();
        }

        $client           = User::where('id', $invoice->client)->first();
        $invoice->name    = !empty($client) ? $client->name : '';
        $invoice->invoice = \Auth::user()->invoiceNumberFormat($invoice->invoice);

        $invoiceId    = \Crypt::encrypt($invoice->id);
        $invoice->url = route('purchaseinvoice.pdf', $invoiceId);


        $invoiceArr = [
            'invoice_id' => \Auth::user()->invoiceNumberFormat($invoice->invoice_id),
            'invoice_client' => $invoice->name,
            'invoice_issue_date' => \Auth::user()->dateFormat($invoice->issue_date),
            'invoice_due_date' => \Auth::user()->dateFormat($invoice->expiry_date),
            'invoice_total' => \Auth::user()->priceFormat($invoice->getTotal()),
            'invoice_sub_total' => \Auth::user()->priceFormat($invoice->getSubTotal()),
            'invoice_due_amount' => \Auth::user()->priceFormat($invoice->getDue()),
            'invoice_status' => \App\Invoice::$statues[$invoice->status],
        ];

        if ($client != null) {
            // $resp = Utility::sendEmailTemplate('send_invoice', [$client->id => $client->email], $invoiceArr);
            return redirect()->back()->with('success', __('Invoice successfully sent.'));
        } else {
            return redirect()->back()->with('success', __("No Client has been seleted"));
        }
        // Send Email
    }

    public function statusChange(Request $request, $id)
    {
        if (\Auth::user()->type == 'company') {
            $status          = $request->status;
            $invoice         = \App\PurchaseInvoice::find($id);
            $invoice->status = $status;
            $invoice->save();

            return redirect()->back()->with('success', __('Invoice status changed successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function storeReceipt(Request $request, $invoice_id)
    {
        // if (\Auth::user()->type == 'company' || \Auth::user()->hasPermissionTo('view stock')) {
        $invoice = \App\PurchaseInvoice::find($invoice_id);
        if ($invoice->type == 'Product') {
            $inv_products = \App\PurchaseInvoiceProduct::query()->where("invoice", "=", $invoice->id)->get();
            foreach ($inv_products as $inv_product) {
                $inv_id = $inv_product->id;
                $qty = $inv_product->quantity;
                $iid = (new \App\Item)->getItemIDByName($inv_product->item);

                $item = \App\Item::find($iid);
                if ($item != null) {
                    if ($item->type == "product") {
                        $cur_qty = (new \App\Item)->getItemQuantity($iid);
                        \App\Item::where("id", $iid)->update(['quantity' => ($cur_qty + $qty)]);
                    }
                }
            }
        }

        $validator = \Validator::make(
            $request->all(),
            [
                'amount' => 'required|numeric|min:1',
                'date' => 'required',
                'payment_method' => 'required',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $transactionId = strtoupper(str_replace('.', '', uniqid('', true)));
        
        $client     = \App\Supplier::find($invoice->client);
        if ($client == null) {
            return redirect()->back()->with('error', __('Set client on invoice.'));
        }

        $expense = new \App\Expense();
        $expense->date = $request->date;
        $expense->amount = $request->amount;
        $expense->created_by = \Auth::user()->creatorId();
        $expense->user = \Auth::user()->creatorId();
        $expense->purchase_invoice = $invoice->id;
        $expense->save();


        \App\PurchaseInvoicePayment::create(
            [
                    'transaction' => $transactionId,
                    'invoice' => $invoice_id,
                    'amount' => $request->amount,
                    'date' => $request->date,
                    'payment_method' => $request->payment_method,
                    'payment_type' => __('Manually'),
                    'notes' => $request->description,
                ]
        );

        $invoice = \App\PurchaseInvoice::find($invoice_id);

        if ($invoice->getDue() <= 0.0) {
            \App\PurchaseInvoice::change_status($invoice->id, 5);
        } elseif ($invoice->getDue() > 0) {
            \App\PurchaseInvoice::change_status($invoice->id, 4);
        } else {
            \App\PurchaseInvoice::change_status($invoice->id, 3);
        }


        $invoiceArr = [
                'invoice_id' => \Auth::user()->invoiceNumberFormat($invoice->invoice_id),
                'invoice_client' => $client->name,
                'invoice_issue_date' => \Auth::user()->dateFormat($invoice->issue_date),
                'invoice_due_date' => \Auth::user()->dateFormat($invoice->expiry_date),
                'invoice_total' => $invoice->getTotal(),
                'invoice_sub_total' => $invoice->getSubTotal(),
                'invoice_due_amount' => $invoice->getDue(),
                'payment_total' => $request->amount,
                'payment_date' => \Auth::user()->dateFormat($request->date),
                'invoice_status' => \App\PurchaseInvoice::$statues[$invoice->status],
            ];

        // Send Email
        if (gettype($client) == "object") {
            if ($client->email != "" || $client->email != null) {
                // $resp = Utility::sendEmailTemplate('invoice_payment_recored', [$client->id => $client->email], $invoiceArr);
            }
        }

        return redirect()->back()->with('success', __('Payment successfully created.'));
        // } else {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
    }

    public function createReceipt($invoice_id)
    {
        $invoice        = \App\PurchaseInvoice::find($invoice_id);
        $paymentMethods = \App\PaymentMethod::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        return view('purchaseinvoice.createReceipt', compact('invoice', 'paymentMethods'));
    }

    public function create()
    {
        $clients = Supplier::query()->where(["created_by" => Auth::user()->creatorId()])->get()->toArray();
        $taxes = TaxRate::where('created_by', Auth::user()->creatorId())->get()->pluck('name', 'id');
        $chartoa = \App\ChartOfAccount::query()->get()->toArray();
        return view('purchaseinvoice.create', compact('clients', 'taxes', 'chartoa'));
    }

    public function destroy($id)
    {
        \App\PurchaseInvoice::where('id', '=', $id)->delete();
        \App\PurchaseInvoicePayment::where('invoice', '=', $id)->delete();
        \App\Expense::where('purchase_invoice', '=', $id)->where('user', Auth::user()->creatorId())->delete();
        return redirect()->back()->with('success', __('Invoice successfully deleted.'));
    }

    public function show($id)
    {
        $ids      = Crypt::decrypt($id);
        $invoice  = \App\PurchaseInvoice::find($ids);
        $settings = Utility::settings();
        $items         = [];
        $totalTaxPrice = 0;
        $totalQuantity = 0;
        $totalRate     = 0;
        $totalDiscount = 0;
        $taxesData     = [];
        foreach ($invoice->items as $item) {
            $totalQuantity += $item->quantity;
            $totalRate     += $item->price;
            $totalDiscount += $item->discount;
            $taxes         = Utility::tax($item->tax);

            $itemTaxes = [];
            // dd($taxes);
            // return false;
            foreach ($taxes as $tax) {
                if ($tax != null) {
                    $taxPrice         = Utility::taxRate($tax->rate, $item->price, $item->quantity);
                    $totalTaxPrice    += $taxPrice;
                    $itemTax['name']  = $tax->name;
                    $itemTax['rate']  = $tax->rate . '%';
                    $itemTax['price'] = \App\Utility::priceFormat($settings, $taxPrice);

                    $itemTaxes[] = $itemTax;
                    if (array_key_exists($tax->name, $taxesData)) {
                        $taxesData[$tax->name] = $taxesData[$tax->name] + $taxPrice;
                    } else {
                        $taxesData[$tax->name] = $taxPrice;
                    }
                }
            }
            $item->itemTax = $itemTaxes;
            $items[]       = $item;
        }

        $invoice->items         = $items;
        $invoice->totalTaxPrice = $totalTaxPrice;
        $invoice->totalQuantity = $totalQuantity;
        $invoice->totalRate     = $totalRate;
        $invoice->totalDiscount = $totalDiscount;
        $invoice->taxesData     = $taxesData;
        $status                 = \App\PurchaseInvoice::$statues;

        return view('purchaseinvoice.view', compact('invoice', 'settings', 'status'));
    }
}
