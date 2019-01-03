@extends('admin.adminlayout')

@section('page-header')
  Loan Request <small>update</small>
@stop

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box" style="border:1px solid #d2d6de;">
        {!! Form::model($loanRequest, [
                'action' => ['LoanRequestController@update', $loanRequest['id']],
                'method' => 'put',
                'files' => true,
                'id' => 'edit-loan-req'
            ])
        !!}

        <div class="box-body" style="margin:10px;">
          @include('admin.loan_request.form')
        </div>

      	<div class="box-footer" style="background-color:#f5f5f5;border-top:1px solid #d2d6de;">
      	  <button type="submit" class="btn btn-info" style="width:100px;">{{ trans('app.update_button') }}</button>
          <a class="btn btn-warning " href="{{ route(ADMIN.'.loan_request.index') }}" style="width:100px;"><i class="fa fa-btn fa-back"></i>Cancel</a>
      	</div>

        {!! Form::close() !!}
    </div>
  </div>
</div>
@stop


@section('js')

<script>
    $(document).ready(function () {

    $("#user_id").select2();
    $('#edit-loan-req').validate({ // initialize the plugin
        rules: {
            user_id: {
                required: true
            },
            loan_amount: {
                required: true                
            },
        }
    });



});
</script>

@stop