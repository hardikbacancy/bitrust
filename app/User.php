<?php

namespace App;
use App\Models\admin\AdminSetting;
use App\Models\admin\LoanRequest;
use App\Models\admin\Membership;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'active', 'avatar','mobile','verification_code','gender','email_verified_at','membership_fees'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */
    public static function rules($update = false, $id = null)
    {
        $commun = [
            'name' => 'required|min:2',
            'email'    => "required|email|unique:users,email,$id",
            'password' => 'nullable|confirmed',
            'mobile' =>'required|digits:10',
            'avatar' => 'image|mimes:jpeg,bmp,png|max:300',
        ];

        if ($update) {
            return $commun;
        }

        return array_merge($commun, [
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
      * Get user role name
      *
      * $return string
      */
    public function rolename()
    {
        return config('variables.role')[$this->attributes['role']];
    }

    /**
      * Find out if user has a specific role
      *
      * $return boolean
      */
     public function hasRole($roles)
     {
        return in_array($this->rolename(), explode("|", $roles));
     }

    /*
    |------------------------------------------------------------------------------------
    | Attributes
    |------------------------------------------------------------------------------------
    */
    public function setPasswordAttribute($value='')
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getAvatarAttribute($value)
    {
        if (!$value) {
            //return 'http://placehold.it/160x160';
            return url('/') . config('variables.avatar.public') . 'avatar0.png';
        }

        return url('/') . config('variables.avatar.public') . $value;
    }
    public function setAvatarAttribute($photo)
    {
        $this->attributes['avatar'] = move_file($photo, 'avatar.image');
    }

    /*
    |------------------------------------------------------------------------------------
    | Boot
    |------------------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();
        static::updating(function($user)
        {
            $original = $user->getOriginal();

            if (\Hash::check('', $user->password)) {
                $user->attributes['password'] = $original['password'];
            }
        });
    }

    public function userLoanDetails(){
        $adminSettings=AdminSetting::all()->toArray();
        $userCount=User::where('role','=',0)->count();
        $loanAmount=LoanRequest::where('request_status','=',1)->sum('loan_amount');
        $totalMembershipFees1=Membership::value(DB::raw("SUM(jan_fees + jan_penalty + feb_fees + feb_penalty + march_fees +march_penalty + april_fees + april_penalty + may_fees + may_penalty + june_fees + june_penalty + july_fees + july_penalty + aug_fees + aug_penalty + sep_fees + sep_penalty + oct_fees)"));
        $totalMembershipFees2=Membership::value(DB::raw("SUM(oct_penalty+nov_fees+nov_penalty+dec_fees+dec_penalty)"));
        $totalMembershipFees=$totalMembershipFees1+$totalMembershipFees2;

        $availableBal=$totalMembershipFees-$loanAmount;
        return $availableBal;
    }
    public function getInterest(){
        $adminSettings=AdminSetting::all()->toArray();
        $interest_rate=$adminSettings[0]['interest_rate'];
        return $interest_rate;
    }
    public function getMembershipFees(){
        $adminSettings=AdminSetting::all()->toArray();
        $membership_fee=$adminSettings[0]['membership_fee'];
        return $membership_fee;
    }
    public function getMinLoanAmount(){
        $adminSettings=AdminSetting::all()->toArray();
        $min_loan_amount=$adminSettings[0]['min_loan_amount'];
        return $min_loan_amount;
    }
}
