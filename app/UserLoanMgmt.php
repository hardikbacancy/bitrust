<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class UserLoanMgmt extends Model
{
    protected $fillable = ['user_id', 'loan_amount','tenuar_period','interest_rate',
        'request_status'];

}