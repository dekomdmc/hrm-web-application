<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceProduct extends Model
{
    protected $fillable = [
        'item',
        'invoice',
        'quantity',
        'tax',
        'discount',
        'total',
    ];

    public function items()
    {
        return $this->hasOne('App\Item', 'id', 'item');
    }
}
