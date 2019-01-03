@if(\Auth::user()->role!='0')
<div class="form-group">
    <label for="user_id">Select User:</label>
    <select class="form-control" id="user_id" name="user_id">
        @foreach($userDetails as $userDetail)
            <option value="{{$userDetail['id']}}"
                    @if(isset($loanRequest))@if($userDetail['id']==$loanRequest['user_id']) selected @endif @endif>{{$userDetail['email']}}</option>
        @endforeach
    </select>
</div>
@endif
{!! Form::myInput('text', 'loan_amount', 'Loan Amount') !!}
<div class="form-group">
    <label for="tenuar_period">Tenuar Period:</label>
    <select class="form-control" id="tenuar_period" name="tenuar_period">
        <option value="6" @if(isset($loanRequest)) @if($loanRequest['tenuar_period']=='6') selected @endif @endif>
            6-Month
        </option>
        <option value="12" @if(isset($loanRequest)) @if($loanRequest['tenuar_period']=='12') selected @endif @endif>
            1-year
        </option>
        <option value="24" @if(isset($loanRequest)) @if($loanRequest['tenuar_period']=='24') selected @endif @endif>
            2-year
        </option>
    </select>
</div>
<div class="form-group">
    <label for="interest_rate">Interest Rate:</label>
    <input type="text" class="form-control" id="interest_rate" name="interest_rate"
           value="{{$adminSettings[0]['interest_rate']}}" readonly>
</div>

@if(isset($loanRequest))
    {!! Form::mySelect('request_status', 'request_status', config('variables.boolean')) !!}
@endif




