<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    protected $fillable = [
        'invoice_id',
        'issue_date',
        'due_date',
        'client',
        'project',
        'tax',
        'type',
        'status',
        'description',
        'created_by',
        'chart_of_account'
    ];

    public static $statues = [
        'Draft',
        'Open',
        'Sent',
        'Unpaid',
        'Partialy Paid',
        'Paid',
    ];
    public static $statuesColor = [
        'Draft' => 'bg-dark',
        'Open' => 'bg-info',
        'Sent' => 'bg-primary',
        'Unpaid' => 'bg-warning',
        'Partialy Paid' => 'bg-danger',
        'Paid' => 'bg-success',
    ];

    public function items()
    {
        return $this->hasMany('App\PurchaseInvoiceProduct', 'invoice', 'id');
    }

    public function projects()
    {
        return $this->hasOne('App\Project', 'id', 'project');
    }

    public function getSubTotal()
    {
        $subTotal = 0;
        foreach ($this->items as $product) {
            $subTotal += ($product->price * $product->quantity);
        }

        return $subTotal;
    }

    public function getTotalTax()
    {
        $totalTax = 0;
        foreach ($this->items as $product) {
            $taxes = Utility::totalTaxRate($product->tax);

            $totalTax += ($taxes / 100) * ($product->price * $product->quantity);
        }

        return $totalTax;
    }

    public function getTotalDiscount()
    {
        $totalDiscount = 0;
        foreach ($this->items as $product) {
            $totalDiscount += $product->discount;
        }

        return $totalDiscount;
    }

    public function getTotal()
    {
        return ($this->getSubTotal() + $this->getTotalTax()) - $this->getTotalDiscount();
    }

    public function getDue()
    {
        $due = 0;
        foreach ($this->payments as $payment) {
            $due += $payment->amount;
        }

        return ($this->getTotal() - $due);
        //        return ($this->getTotal() - $due) - $this->invoiceTotalCreditNote();
    }

    public function payments()
    {
        return $this->hasMany('App\PurchaseInvoicePayment', 'invoice', 'id');
    }

    public function creditNote()
    {
        return $this->hasMany('App\CreditNote', 'invoice', 'id');
    }

    public static function change_status($invoice_id, $status)
    {
        $invoice         = PurchaseInvoice::find($invoice_id);
        $invoice->status = $status;
        $invoice->update();
    }

    public function getInvoiceClientNameById($client_id)
    {
        $supplier = \App\Supplier::find($client_id);
        return $supplier->company_name;
    }
}
