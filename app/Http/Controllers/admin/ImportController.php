<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        return view('admin.import');
    }

    public function importMembership(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'import_file' => 'required',
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } else {

            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function ($reader) {
            })->get();

            if (!empty($data) && $data->count()) {
                foreach ($data as $key => $value) {
                    $full_name = $value->name;
                    $res=strpos($full_name, "(");

                    if($res>0){
                        $full_name_trim = substr($full_name, 0, strpos($full_name, "("));
                    }
                    else{
                        $full_name_trim=$full_name;
                    }

                    $new_full_name_explode= explode(" ",$full_name_trim);
                    if(!empty($new_full_name_explode[0]) && !empty($new_full_name_explode[1]) && !empty($new_full_name_explode[2]) ){
                        $first_name=$new_full_name_explode[0];
                        $middle_name=$new_full_name_explode[1];
                        $last_name=$new_full_name_explode[2];
                    }

                    else if(!empty($new_full_name_explode[0]) && !empty($new_full_name_explode[1])) {
                        $first_name=$new_full_name_explode[0];
                        $middle_name=" ";
                        $last_name=$new_full_name_explode[1];
                    }
                    else{

                    }

                    $jan_fees =!empty($value->jan) ? trim($value->jan,"$") : 0;
                    $feb_fees =!empty($value->feb) ? trim($value->feb,"$") : 0;
                    $march_fees =!empty($value->march) ? trim($value->march,"$") : 0;
                    $april_fees =!empty($value->april) ? trim($value->april,"$") : 0;
                    $may_fees =!empty($value->may) ? trim($value->may,"$") : 0;
                    $june_fees =!empty($value->june) ? trim($value->june,"$") : 0;
                    $july_fees =!empty($value->july) ? trim($value->july,"$") : 0;
                    $aug_fees =!empty($value->aug) ? trim($value->aug,"$") : 0;
                    $sep_fees =!empty($value->sep) ? trim($value->sep,"$") : 0;
                    $oct_fees =!empty($value->oct) ? trim($value->oct,"$") : 0;
                    $nov_fees =!empty($value->nov) ? trim($value->nov,"$") : 0;
                    $dec_fees =!empty($value->dec) ? trim($value->dec,"$") : 0;

                    if ($jan_fees > 100) {
                        $jan_penalty = $jan_fees - 100;
                        $jan_fees = 100;
                    } else {
                        $jan_penalty = 0;
                    }
                    if ($feb_fees > 100) {
                        $feb_penalty = $feb_fees - 100;
                        $feb_fees = 100;
                    } else {
                        $feb_penalty = 0;
                    }
                    if ($march_fees > 100) {
                        $march_penalty = $march_fees - 100;
                        $march_fees = 100;
                    } else {
                        $march_penalty = 0;
                    }
                    if ($april_fees > 100) {
                        $april_penalty = $april_fees - 100;
                        $april_fees = 100;
                    } else {
                        $april_penalty = 0;

                    }
                    if ($may_fees > 100) {
                        $may_penalty = $may_fees - 100;
                        $may_fees = 100;
                    } else {
                        $may_penalty = 0;
                    }
                    if ($june_fees > 100) {
                        $june_penalty = $june_fees - 100;
                        $june_fees = 100;
                    } else {
                        $june_penalty = 0;
                    }
                    if ($july_fees > 100) {
                        $july_penalty = $july_fees - 100;
                        $july_fees = 100;
                    } else {
                        $july_penalty = 0;
                    }
                    if ($aug_fees > 100) {
                        $aug_penalty = $aug_fees - 100;
                        $aug_fees = 100;
                    } else {
                        $aug_penalty = 0;
                    }
                    if ($sep_fees > 100) {
                        $sep_penalty = $sep_fees - 100;
                        $sep_fees = 100;
                    } else {
                        $sep_penalty = 0;
                    }
                    if ($oct_fees > 100) {
                        $oct_penalty = $oct_fees - 100;
                        $oct_fees = 100;
                    } else {
                        $oct_penalty = 0;
                    }
                    if ($nov_fees > 100) {
                        $nov_penalty = $nov_fees - 100;
                        $nov_fees = 100;
                    } else {
                        $nov_penalty = 0;
                    }
                    if ($dec_fees > 100) {
                        $dec_penalty = $dec_fees - 100;
                        $dec_fees = 100;
                    } else {
                        $dec_penalty = 0;
                    }

                    $insert[] = ['first_name' =>$first_name,'middle_name'=>$middle_name,'last_name'=>$last_name,'year' => '2018', 'jan_fees' => $jan_fees, 'feb_fees' => $feb_fees,
                        'march_fees' => $march_fees, 'april_fees' => $april_fees,
                        'may_fees' => $may_fees,
                        'june_fees' => $june_fees,
                        'july_fees' => $july_fees,
                        'aug_fees' => $aug_fees,
                        'sep_fees' => $sep_fees,
                        'oct_fees' => $oct_fees,
                        'nov_fees' => $nov_fees,
                        'dec_fees' => $dec_fees,
                        'jan_penalty' => $jan_penalty, 'feb_penalty' => $feb_penalty,
                        'march_penalty' => $march_penalty, 'april_penalty' => $april_penalty,
                        'may_penalty' => $may_penalty,
                        'june_penalty' => $june_penalty,
                        'july_penalty' => $july_penalty,
                        'aug_penalty' => $aug_penalty,
                        'sep_penalty' => $sep_penalty,
                        'oct_penalty' => $oct_penalty,
                        'nov_penalty' => $nov_penalty,
                        'dec_penalty' => $dec_penalty,
                    ];
                }

                if (!empty($insert)) {
                    DB::table('memberships_demo')->insert($insert);
                }
            }
            return back()->with('message', 'Imported Successfully!');
        }
    }
}
