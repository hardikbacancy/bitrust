<div class="form-group">
    <label for="gender">Select User:</label>
    <select class="form-control" id="user_id" name="user_id">
        @foreach($userDetails as $userDetail)
        <option value="{{$userDetail['id']}}" @if(isset($loanRequest))@if($userDetail['id']==$loanRequest['user_id']) selected @endif @endif>{{$userDetail['email']}}</option>
        @endforeach
    </select>
</div>

{!! Form::myInput('text', 'loan_amount', 'Loan Amount') !!}
{!! Form::myInput('text', 'tenuar_period', 'Tenuar Period') !!}
{!! Form::myInput('text', 'interest_rate', 'Interest Rate') !!}

{!! Form::mySelect('request_status', 'request_status', config('variables.boolean')) !!}




