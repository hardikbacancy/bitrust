<?php

namespace App;

use App\Models\admin\AdminSetting;
use App\Models\admin\LoanRequest;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        'name', 'email', 'password', 'role', 'active', 'avatar','mobile','verification_code','gender','email_verified_at'
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
        $roleId=auth()->user()->hasRole('user');
        $userCount=User::where('role','=',$roleId)->count();
        $loanAmount=LoanRequest::where('request_status','=',1)->sum('loan_amount');
        $availableBal=($adminSettings[0]['membership_fee']*$userCount)-$loanAmount;
        return $availableBal;
    }

}
