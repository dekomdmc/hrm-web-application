<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    protected $fillable = [
        "id",
        'name',
        'created_by',
    ];

    function getNameById($id){
        $name = $this->query()->where("id", $id)->get()->toArray();

    }

}
