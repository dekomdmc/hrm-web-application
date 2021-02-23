<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'type',
        'created_by',
    ];

    public static $categoryType = [
        'Item',
        'Estimates',
        'Project',
    ];
}
