<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{	
	//protected $table = 'admin_settings';
    protected $fillable = ['penalty', 'interest_rate','membership_fee','min_loan_amount'];
    
}
