<?php
$allowedRoles = config('variables.role');
if (Auth::user()->rolename() !== "Superadmin") {
    foreach ($allowedRoles as $key => $value) {
        if ($key >= Auth::user()->role) {
            unset($allowedRoles[$key]);
        }
    }
}

unset($allowedRoles['5']); // remove superadmin option
//$img_url = (isset($item) ? $item->avatar : "http://placehold.it/160x160");
$img_url = (isset($item) ? $item->avatar : url('/') . config('variables.avatar.public') . 'avatar0.png');
$val = str_random(40);

?>
<input type="hidden" name="email_verified_at" value="1">
<input type="hidden" name="verification_code" value={{$val}}>
<input type="hidden" name="membership_fees" value="150">
{!! Form::myInput('text', 'name', 'Name <span>*</span>') !!}
<div class="form-group">
    <label for="username">Username<span>*</span></label>
    <input class="form-control" type="text" name="username" id="username"
           value="@if(isset($item['username'])){{$item['username']}}@endif">
</div>
{!! Form::myInput('email', 'email', 'Email <span>*</span>') !!}
{!! Form::myInput('text', 'mobile', 'Mobile <span>*</span>') !!}
<div class="form-group">
    <label for="address">Address<span>*</span></label>
    <input class="form-control" type="text" name="address" id="address"
           value="@if(isset($item['address'])){{$item['address']}}@endif">
</div>

<div class="form-group">
    <label for="birthdate">Birthdate<span>*</span></label>
    <input class="form-control" type="date" name="birthdate" id="birthdate"
           value="@if(isset($item['birthdate'])){{$item['birthdate']}}@endif">
</div>

<div class="form-group">
    <label for="social_insurance_number">Social Insurance Number</label>
    <input class="form-control" type="text" name="social_insurance_number" id="social_insurance_number"
           value="@if(isset($item['social_insurance_number'])){{$item['social_insurance_number']}}@endif">
</div>


<p><b>Beneficiary <span style="color:red;">*</span></b></p>
<div class="beneficiary-box">

    <div class="row formbox">
        <div class="form-group col-sm-4{{ $errors->has('first_beneficiary_name') ? ' has-error' : '' }} has-feedback">
            <input type="text" class="form-control" placeholder="First Beneficiary Name" name="first_beneficiary_name"
                   value="@if(isset($item['first_beneficiary_name'])){{$item['first_beneficiary_name']}}@endif">

            @if ($errors->has('first_beneficiary_name'))
                <span class="help-block">
                            <strong>{{ $errors->first('first_beneficiary_name') }}</strong>
                </span>
            @endif
        </div>


        <div class="form-group  col-sm-4{{ $errors->has('first_beneficiary_relationship') ? ' has-error' : '' }} has-feedback">
            <select class="form-control" name="first_beneficiary_relationship">
                <option value="">--Relationship--</option>
                <option value="Father" @if(isset($item['first_beneficiary_relationship'])) @if($item['first_beneficiary_relationship']=="Father") selected @endif @endif>Father</option>
                <option value="Mother" @if(isset($item['first_beneficiary_relationship']))@if($item['first_beneficiary_relationship']=="Mother") selected @endif @endif>Mother</option>
                <option value="Husband" @if(isset($item['first_beneficiary_relationship']))@if($item['first_beneficiary_relationship']=="Husband") selected @endif @endif>Husband</option>
                <option value="Wife" @if(isset($item['first_beneficiary_relationship']))@if($item['first_beneficiary_relationship']=="Wife") selected @endif @endif>Wife</option>
                <option value="Son" @if(isset($item['first_beneficiary_relationship']))@if($item['first_beneficiary_relationship']=="Son") selected @endif @endif>Son</option>
                <option value="Daughter" @if(isset($item['first_beneficiary_relationship']))@if($item['first_beneficiary_relationship']=="Daughter") selected @endif @endif>Daughter</option>
                <option value="Uncle" @if(isset($item['first_beneficiary_relationship']))@if($item['first_beneficiary_relationship']=="Uncle") selected @endif @endif>Uncle</option>
                <option value="Aunt" @if(isset($item['first_beneficiary_relationship']))@if($item['first_beneficiary_relationship']=="Aunt") selected @endif @endif>Aunt</option>
                <option value="Cousin" @if(isset($item['first_beneficiary_relationship']))@if($item['first_beneficiary_relationship']=="Cousin") selected @endif @endif>Cousin</option>
                <option value="Nephew" @if(isset($item['first_beneficiary_relationship']))@if($item['first_beneficiary_relationship']=="Nephew") selected @endif @endif>Nephew</option>
                <option value="Niece" @if(isset($item['first_beneficiary_relationship']))@if($item['first_beneficiary_relationship']=="Niece") selected @endif @endif>Niece</option>
                <option value="Grandfather" @if(isset($item['first_beneficiary_relationship']))@if($item['first_beneficiary_relationship']=="Grandfather") selected @endif @endif>Grandfather</option>
                <option value="Grandmother" @if(isset($item['first_beneficiary_relationship']))@if($item['first_beneficiary_relationship']=="Grandmother") selected @endif @endif>Grandmother</option>
                <option value="Grandson" @if(isset($item['first_beneficiary_relationship']))@if($item['first_beneficiary_relationship']=="Grandson") selected @endif @endif>Grandson</option>
                <option value="Granddaughter" @if(isset($item['first_beneficiary_relationship']))@if($item['first_beneficiary_relationship']=="Granddaughter") selected @endif @endif>Granddaughter</option>

            </select>
            @if ($errors->has('first_beneficiary_relationship'))
                <span class="help-block">
                            <strong>{{ $errors->first('first_beneficiary_relationship') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group  col-sm-4{{ $errors->has('first_beneficiary_share') ? ' has-error' : '' }} has-feedback">
            <input type="text" class="form-control" placeholder="Beneficiary Percentage Share"
                   name="first_beneficiary_share" value="@if(isset($item['first_beneficiary_share'])){{$item['first_beneficiary_share']}}@endif">

            @if ($errors->has('first_beneficiary_share'))
                <span class="help-block">
                            <strong>{{ $errors->first('first_beneficiary_share') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="row formbox">
        <div class="form-group col-sm-4{{ $errors->has('second_beneficiary_name') ? ' has-error' : '' }} has-feedback">
            <input type="text" class="form-control" placeholder="Second Beneficiary Name" name="second_beneficiary_name"
                   value="@if(isset($item['second_beneficiary_name'])){{$item['second_beneficiary_name']}}@endif">

            @if ($errors->has('second_beneficiary_name'))
                <span class="help-block">
                            <strong>{{ $errors->first('second_beneficiary_name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group col-sm-4 {{ $errors->has('second_beneficiary_relationship') ? ' has-error' : '' }} has-feedback">
            <select class="form-control" name="second_beneficiary_relationship">
                <option value="">--Relationship--</option>
                <option value="Father" @if(isset($item['second_beneficiary_relationship'])) @if($item['second_beneficiary_relationship']=="Father") selected @endif @endif>Father</option>
                <option value="Mother" @if(isset($item['second_beneficiary_relationship']))@if($item['second_beneficiary_relationship']=="Mother") selected @endif @endif>Mother</option>
                <option value="Husband" @if(isset($item['second_beneficiary_relationship']))@if($item['second_beneficiary_relationship']=="Husband") selected @endif @endif>Husband</option>
                <option value="Wife" @if(isset($item['second_beneficiary_relationship']))@if($item['second_beneficiary_relationship']=="Wife") selected @endif @endif>Wife</option>
                <option value="Son" @if(isset($item['second_beneficiary_relationship']))@if($item['second_beneficiary_relationship']=="Son") selected @endif @endif>Son</option>
                <option value="Daughter" @if(isset($item['second_beneficiary_relationship']))@if($item['second_beneficiary_relationship']=="Daughter") selected @endif @endif>Daughter</option>
                <option value="Uncle" @if(isset($item['second_beneficiary_relationship']))@if($item['second_beneficiary_relationship']=="Uncle") selected @endif @endif>Uncle</option>
                <option value="Aunt" @if(isset($item['second_beneficiary_relationship']))@if($item['second_beneficiary_relationship']=="Aunt") selected @endif @endif>Aunt</option>
                <option value="Cousin" @if(isset($item['second_beneficiary_relationship']))@if($item['second_beneficiary_relationship']=="Cousin") selected @endif @endif>Cousin</option>
                <option value="Nephew" @if(isset($item['second_beneficiary_relationship']))@if($item['second_beneficiary_relationship']=="Nephew") selected @endif @endif>Nephew</option>
                <option value="Niece" @if(isset($item['second_beneficiary_relationship']))@if($item['second_beneficiary_relationship']=="Niece") selected @endif @endif>Niece</option>
                <option value="Grandfather" @if(isset($item['second_beneficiary_relationship']))@if($item['second_beneficiary_relationship']=="Grandfather") selected @endif @endif>Grandfather</option>
                <option value="Grandmother" @if(isset($item['second_beneficiary_relationship']))@if($item['second_beneficiary_relationship']=="Grandmother") selected @endif @endif>Grandmother</option>
                <option value="Grandson" @if(isset($item['second_beneficiary_relationship']))@if($item['second_beneficiary_relationship']=="Grandson") selected @endif @endif>Grandson</option>
                <option value="Granddaughter" @if(isset($item['second_beneficiary_relationship']))@if($item['second_beneficiary_relationship']=="Granddaughter") selected @endif @endif>Granddaughter</option>

            </select>
            @if ($errors->has('second_beneficiary_relationship'))
                <span class="help-block">
                            <strong>{{ $errors->first('second_beneficiary_relationship') }}</strong>
                </span>
            @endif
        </div>


        <div class="form-group col-sm-4 {{ $errors->has('second_beneficiary_share') ? ' has-error' : '' }} has-feedback">
            <input type="text" class="form-control" placeholder="Beneficiary Percentage Share"
                   name="second_beneficiary_share" value="@if(isset($item['second_beneficiary_share'])){{$item['second_beneficiary_share']}}@endif">

            @if ($errors->has('second_beneficiary_share'))
                <span class="help-block">
                            <strong>{{ $errors->first('second_beneficiary_share') }}</strong>
                </span>
            @endif
        </div>

    </div>
</div>

<div class="form-group">
    <label for="membership_fees">Default Membership Fees<span style="color: red;">*</span></label>
    <input class="form-control" type="text" name="membership_fees" id="membership_fees"
           value="@if(isset($item['membership_fees'])){{$item['membership_fees']}}@endif">
</div>

@if(isset($item->id))
    {!! Form::myInput('password', 'password', 'Password') !!}
    {!! Form::myInput('password', 'password_confirmation', 'Password confirmation') !!}
@else
    {!! Form::myInput('password', 'password', 'Password <span>*</span>') !!}
    {!! Form::myInput('password', 'password_confirmation', 'Password confirmation <span>*</span>') !!}
@endif




{{--<div class="form-group">--}}
{{--<label for="gender">Gender:</label>--}}
{{--<select class="form-control" id="gender" name="gender">--}}
{{--<option value="male" @if(isset($item)) @if($item['gender']=='male') selected @endif @endif>MALE</option>--}}
{{--<option value="female" @if(isset($item)) @if($item['gender']=='female') selected @endif @endif>FEMALE</option>--}}
{{--</select>--}}
{{--</div>--}}

{{--{!! Form::mySelect('role', 'Role', $allowedRoles) !!}--}}
@if(isset($item->id))
@else
    {!! Form::mySelect('active', 'Active', config('variables.boolean')) !!}
@endif

{{--@if(isset($item->id))--}}
{{--{!! Form::myFileImage('avatar', 'Photo', $img_url) !!}--}}
{{--@else--}}
{{--{!! Form::myFileImage('avatar', 'Photo <span>*</span>', $img_url) !!}--}}
{{--@endif--}}
