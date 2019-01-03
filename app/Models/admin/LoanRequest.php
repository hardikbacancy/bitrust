<?php

namespace App\Models\admin;
use Illuminate\Database\Eloquent\Model;

class LoanRequest extends Model
{
    protected $fillable = ['user_id', 'loan_amount','tenuar_period','interest_rate',
        'request_status'];



}
