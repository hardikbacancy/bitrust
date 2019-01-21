@extends('admin.adminlayout')

@section('page-header')
  Loan Request <small>new</small>
@stop

@section('content')
    @if(session()->has('message'))
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {!! session('message') !!}
        </div>
    @endif

<div class="row">
  <div class="col-sm-12">
    <div class="box" style="border:1px solid #d2d6de;">
        {!! Form::open([
                'action' => ['LoanRequestController@store'],
                'files' => true,
                'id' => 'create-loan-req'
            ])
        !!}

        <div class="box-body number_class" style="margin:10px;">
          @include('admin.loan_request.form')
        </div>

      	<div class="box-footer" style="background-color:#f5f5f5;border-top:1px solid #d2d6de;">
      	  <button type="submit" class="btn btn-info" style="width:100px;">Save</button>
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
    $('#create-loan-req').validate({ // initialize the plugin
        rules: {
            user_id: {
                required: true
            },
            loan_amount: {
                required: true                
            },
        }
    });
        $("body").on('keypress', '.number_class', function (event) {
            if(isNumberWithoutDot(event, this)){
                return true;
            }
            else{
                return false;
            }
        });
        function isNumberWithoutDot(evt, element) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode == 8) {
                return true;
            }
            if ((charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }



});
</script>

@stop