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

{!! Form::myInput('email', 'email', 'Email <span>*</span>') !!}
{!! Form::myInput('text', 'mobile', 'Mobile <span>*</span>') !!}

@if(isset($item->id))
{!! Form::myInput('password', 'password', 'Password') !!}
{!! Form::myInput('password', 'password_confirmation', 'Password confirmation') !!}
@else
  {!! Form::myInput('password', 'password', 'Password <span>*</span>') !!}
  {!! Form::myInput('password', 'password_confirmation', 'Password confirmation <span>*</span>') !!}
@endif


<div class="form-group">
  <label for="gender">Gender:</label>
  <select class="form-control" id="gender" name="gender">
    <option value="male" @if(isset($item)) @if($item['gender']=='male') selected @endif @endif>MALE</option>
    <option value="female" @if(isset($item)) @if($item['gender']=='female') selected @endif @endif>FEMALE</option>
  </select>
</div>

{!! Form::mySelect('role', 'Role', $allowedRoles) !!}

{!! Form::mySelect('active', 'Active', config('variables.boolean')) !!}
{{--@if(isset($item->id))--}}
{{--{!! Form::myFileImage('avatar', 'Photo', $img_url) !!}--}}
{{--@else--}}
  {{--{!! Form::myFileImage('avatar', 'Photo <span>*</span>', $img_url) !!}--}}
{{--@endif--}}
