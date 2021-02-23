<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoicePayment extends Model
{
    protected $fillable = [
        'transaction',
        'invoice',
        'amount',
        'date',
        'payment_method',
        'payment_type',
        'notes',
    ];

    public function payments()
    {
        return $this->hasOne('App\PaymentMethod', 'id', 'payment_method');
    }
}
