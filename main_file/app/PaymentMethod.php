<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'created_by',
    ];

    public function getTotalCashReceived($id)
    {
        $payments = \App\InvoicePayment::where('payment_method', $id)->get();
        $purchasePayments = \App\PurchaseInvoicePayment::where('payment_method', $id)->get();
        $paymentDefaultCashs = \App\Payment::where('payment_method', $id)->get();
        $total = 0;

        foreach ($paymentDefaultCashs as $defaultCash) {
            $total += $defaultCash->amount;
        }

        foreach ($payments as $payment) {
            $total += $payment->amount;
        }

        foreach ($purchasePayments as $payment) {
            $total -= $payment->amount;
        }

        return $total;
    }

    public static function getNameById($id)
    {
        $pm = PaymentMethod::find($id);
        if ($pm != null) {
            return $pm->name;
        }
    }
}
