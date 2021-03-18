<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockItemsExport implements WithHeadings, FromCollection
{

    use Exportable;

    public function headings(): array
    {
        return ['NAME', 'SKU', 'SALE PRICE', 'PURCHASE PRICE', 'QTY', 'TAX', 'CATEGORY', 'UNIT', 'TYPE', 'DESCRIPTION'];
    }

    public function collection()
    {
        $items = \App\StockItem::query()->where("type","service")->get(['name', 'sku', 'sale_price', 'purchase_price', 'quantity', 'tax', 'category', 'unit', 'type', 'description']);
        foreach ($items as $item) {
            $item->unit = (new \App\StockItem)->getUnitNameById($item->unit);
            $item->category = (new \App\StockItem)->getCategoryNameById($item->category);
        }
        return $items;
    }
}
