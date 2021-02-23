<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Termination extends Model
{
    protected $fillable = [
        'employee_id',
        'notice_date',
        'termination_date',
        'termination_type',
        'description',
        'created_by',
    ];

    public function terminationType()
    {
        return $this->hasOne('App\TerminationType', 'id', 'termination_type');
    }

    public function employee()
    {
        return $this->hasOne('App\User', 'id', 'employee_id');
    }
}
