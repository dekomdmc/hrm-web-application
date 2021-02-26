<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StockItem extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'sale_price',
        'purchase_price',
        'tax',
        'quantity',
        'category',
        'unit',
        'type',
        'description',
        'created_by',
    ];
}
