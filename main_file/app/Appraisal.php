<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appraisal extends Model
{
    protected $fillable = [
        'employee',
        'appraisal_date',
        'customer_experience',
        'marketing',
        'administration',
        'professionalism',
        'integrity',
        'attendance',
        'remark',
        'created_by',
    ];

    public static $technical = [
        'None',
        'Beginner',
        'Intermediate',
        'Advanced',
        'Expert / Leader',
    ];

    public static $organizational = [
        'None',
        'Beginner',
        'Intermediate',
        'Advanced',
    ];


    public function user()
    {
        return $this->hasOne('App\User', 'id', 'employee');
    }

    public function employees()
    {
        return $this->hasOne('App\Employee', 'user_id', 'employee');
    }
}
