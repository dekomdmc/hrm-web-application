<?php

namespace App\Imports;

use App\Item;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;

class StockItemsImport implements ToModel
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (trim($row[1]) != "NAME") {
            return new Item([
                'name' => $row[1],
                'sku' => $row[2],
                'sale_price' => $row[3],
                'purchase_price' => $row[4] == "" ? 0.00 : $row[4],
                'quantity' => $row[5] == "" ? 0 : $row[5],
                'tax' => $row[6] == "" ? 0 : $row[6],
                'category' => (new Item)->getCategoryIdByName($row[7]),
                'unit' => (new Item)->getUnitIdByName($row[8]),
                'type' => $row[9],
                'description' => $row[10]
            ]);
        }
    }
}
