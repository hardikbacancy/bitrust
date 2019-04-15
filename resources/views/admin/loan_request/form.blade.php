@if (auth()->user()->hasRole('Superadmin|Admin'))
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
{!! Form::myInput('text', 'loan_amount', 'Loan Amount(in $) <span>*</span>') !!}
<div class="form-group">
    <label for="tenuar_period">Tenure Period:</label>
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
        <option value="36" @if(isset($loanRequest)) @if($loanRequest['tenuar_period']=='36') selected @endif @endif>
            3-year
        </option>
        <option value="48" @if(isset($loanRequest)) @if($loanRequest['tenuar_period']=='48') selected @endif @endif>
            4-year
        </option>
    </select>
</div>


    @if (auth()->user()->hasRole('Superadmin|Admin'))
    {!! Form::mySelect('request_status', 'Approve Request Status', config('variables.boolean')) !!}
    @endif





