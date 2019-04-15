<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public $timestamps = false;
    protected $fillable = ['id','expense_type'];

    public function comments()
    {
        return $this->hasMany('App\Models\admin\ExpenseDetail');
    }
}
