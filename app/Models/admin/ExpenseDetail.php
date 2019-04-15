<?php

namespace App\Models\admin;
use Illuminate\Database\Eloquent\Model;

class ExpenseDetail extends Model
{
    protected $fillable = ['id','expense_id','year','month','expense'];

}
