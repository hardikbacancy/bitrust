<?php

namespace App\Models\admin;
use Illuminate\Database\Eloquent\Model;

class UserLoanMgmt extends Model
{
    protected $fillable = ['user_id', 'loan_amount','tenuar_period','interest_rate',
        'request_status','request_id','emi_amount','emi_paid_date','tenuar_date'];

}
