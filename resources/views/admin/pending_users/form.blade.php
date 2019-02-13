<?php
  $allowedRoles = config('variables.role');
  if (Auth::user()->rolename() !== "Superadmin") {
    foreach ($allowedRoles as $key => $value ) {
      if ($key >= Auth::user()->role) {
          unset($allowedRoles[$key]);
      }
    }
  }

  unset($allowedRoles['5']); // remove superadmin option
  //$img_url = (isset($item) ? $item->avatar : "http://placehold.it/160x160");
  $img_url = (isset($item) ? $item->avatar : url('/') . config('variables.avatar.public') . 'avatar0.png');
  $val=str_random(40);

?>
<input type="hidden" name="email_verified_at" value="1">
<input type="hidden" name="verification_code" value={{$val}}>
{!! Form::myInput('text', 'name', 'Name <span>*</span>') !!}
<div class="form-group">
  <label for="username">Username:</label>
  <input class="form-control" type="text" name="username" id="username" value="{{$item['username']}}">
</div>
{!! Form::myInput('email', 'email', 'Email <span>*</span>') !!}
{!! Form::myInput('text', 'mobile', 'Mobile <span>*</span>') !!}

<div class="form-group">
  <label for="address">Address<span>*</span></label>
  <input class="form-control" type="text" name="address" id="address" value="@if(isset($item['address'])){{$item['address']}}@endif">
</div>

<div class="form-group">
  <label for="birthdate">Birthdate<span>*</span></label>
  <input class="form-control" type="date" name="birthdate" id="birthdate" value="@if(isset($item['birthdate'])){{$item['birthdate']}}@endif">
</div>

<div class="form-group">
  <label for="social_insurance_number">Social Insurance Number</label>
  <input class="form-control" type="text" name="social_insurance_number" id="social_insurance_number" value="@if(isset($item['social_insurance_number'])){{$item['social_insurance_number']}}@endif">
</div>


@if(isset($item->id))
{!! Form::myInput('password', 'password', 'Password') !!}
{!! Form::myInput('password', 'password_confirmation', 'Password confirmation') !!}
@else
  {!! Form::myInput('password', 'password', 'Password <span>*</span>') !!}
  {!! Form::myInput('password', 'password_confirmation', 'Password confirmation <span>*</span>') !!}
@endif


{!! Form::mySelect('active', 'Active', config('variables.boolean')) !!}
{{--@if(isset($item->id))--}}
{{--{!! Form::myFileImage('avatar', 'Photo', $img_url) !!}--}}
{{--@else--}}
  {{--{!! Form::myFileImage('avatar', 'Photo <span>*</span>', $img_url) !!}--}}
{{--@endif--}}
