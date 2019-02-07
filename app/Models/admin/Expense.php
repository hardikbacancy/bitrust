<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public function comments()
    {
        return $this->hasMany('App\Models\admin\ExpenseDetail');
    }
}
