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

    public function units()
    {
        return $this->hasOne('App\Unit', 'id', 'unit');
    }

    public function categories()
    {
        return $this->hasOne('App\Category', 'id', 'category');
    }

    public function tax($taxes)
    {
        $taxArr = explode(',', $taxes);

        $taxes = [];
        foreach ($taxArr as $tax) {
            $taxes[] = TaxRate::find($tax);
        }

        return $taxes;
    }

    public function taxRate($taxes)
    {
        $taxArr  = explode(',', $taxes);
        $taxRate = 0;
        // if(is_array($taxArr) && count($taxArr) > 0){
        //     foreach ($taxArr as $tax) {
        //         $tax     = TaxRate::find($tax);
        //         $taxRate += $tax->rate;
        //     }
        // }
        return $taxRate;
    }

    public function taxes()
    {
        $taxes = $this->hasOne('App\TaxRate', 'id', 'tax')->get()->toArray();
        $taxes == null ? [] : $taxes;
    }

    public function getItemIDByName(string $name)
    {
        $item = DB::table('items')->where("name", "=", $name)->get();
        if(count($item) == 1){
            return $item[0]->id;
        }else{
            return null;
        }
    }

    public function getItemQuantity(int $item_id)
    {
        $item = DB::table('items')->where("id", "=", $item_id)->get();
        return $item[0]->quantity;
    }

    public function getUnitNameById(int $id): string
    {
        $data = DB::table('units')->select('name')->where('id', $id)->get();
        return $data[0]->name;
    }

    public function getUnitIdByName(string $name): int
    {
        $data = DB::table('units')->select('id')->where('name', $name)->get();
        $id = count($data) == 1 ? $data[0]->id : 1;
        return $id;
    }

    public function getCategoryNameById(int $id): string
    {
        $data = DB::table('categories')->select('name')->where('id', $id)->get();
        $name = count($data) == 1 ? $data[0]->name : "No Category";
        return $name;
    }

    public function getCategoryIdByName(string $name): int
    {
        $data = DB::table('categories')->select('id')->where('name', $name)->get();
        $id = count($data) == 1 ? $data[0]->id : 1;
        return $id;
    }

}
