@extends('admin.adminlayout')

@section('page-header')
  Loan Request <small>update</small>
@stop

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box" style="border:1px solid #d2d6de;">
        {!! Form::model([
                'action' => ['LoanRequestController@loanTenuarEdit'],
                'method' => 'post',
                'files' => true
            ])
        !!}

        <div class="box-body" style="margin:10px;">
            {!! Form::mySelect('tenuar_status', 'tenuar_status', config('variables.boolean')) !!}
        </div>

      	<div class="box-footer" style="background-color:#f5f5f5;border-top:1px solid #d2d6de;">
      	  <button type="submit" class="btn btn-info" style="width:100px;">{{ trans('app.update_button') }}</button>
          <a class="btn btn-warning" href="" style="width:100px;"><i class="fa fa-btn fa-back"></i>Cancel</a>
      	</div>

        {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
