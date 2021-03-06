<?php

if (! function_exists('move_file')) {
    function move_file($file, $type='products.slide', $withWatermark = false)
    {
        // Grab all variables
        $path = explode('.', $type)[0];
        $destinationPath = config('variables.'.$path.'.folder');
        $width           = config('variables.' . $type . '.width');
        $height          = config('variables.' . $type . '.height');
        $full_name       = str_random(16) . '.' . $file->getClientOriginalExtension();

        if ($width == null && $height == null) { // Just move the file
            $file->storeAs($destinationPath, $full_name);
            return $full_name;
        }

        // Create the Image
        $image           = Image::make($file->getRealPath());

        if ($width == null || $height == null) {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }else{
            $image->fit($width, $height);
        }

        if ($withWatermark) {
            $watermark = Image::make(public_path() . '/img/watermark.png')->resize($width * 0.5, null);

            $image->insert($watermark, 'center');
        }

        return $image->save($destinationPath . '/' . $full_name)->basename;
    }
}
function checkLoanMenu()
{
    if(\Auth::user()->role==0) {
        $userDetails = \App\Models\admin\Membership::
        join('users', 'users.id', '=', 'memberships.user_id')
            ->select('users.*')
            ->where('users.role','=',0)
            ->where('memberships.user_id','=',\Auth::user()->id)
            ->count();
        return $userDetails;
    }
}
function countUnverifiedUser(){
    $count=\App\User::where('active','=',0)->count();
    return $count;
}
function countUnverifiedRequest(){
    $count=\App\Models\admin\LoanRequest::where('request_status','=',0)->count();
    return $count;
}