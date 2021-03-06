@extends('admin.adminlayout')

@section('page-header')
  Setting <small>update</small>
@stop

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box" style="border:1px solid #d2d6de;">

        {!! Form::model($item, [
                'action' => ['admin\AdminSettingController@update', $item->id],
                'method' => 'put',
                'id' => 'edit-setting',
                'files' => true
            ])
        !!}

        <div class="box-body" style="margin:10px;">
          @include('admin.settings.form')
        </div>
       
      	<div class="box-footer" style="background-color:#f5f5f5;border-top:1px solid #d2d6de;">
      	  <button type="submit" class="btn btn-info" style="width:100px;">{{ trans('app.update_button') }}</button>
          <a class="btn btn-warning " href="{{ route(ADMIN.'.adminsettings.index') }}" style="width:100px;"><i class="fa fa-btn fa-back"></i>Cancel</a>
      	</div>

        {!! Form::close() !!}
    </div>
  </div>
</div>
@stop

@section('js')



 <script>
    $(document).ready(function () {
    $('#edit-setting').validate({ // initialize the plugin
        rules: {
            penalty: {
                required: true
            },
            interest_rate: {
                required: true                
            },      
            membership_fee: {
                required: true               
            },
            min_loan_amount: {
                required: true
            },
        }
    });
        $("body").on('keypress', '.number_class', function (event) {
            if(isNumberWithDot(event, this)){
                return true;
            }
            else{
                return false;
            }
        });

        function isNumberWithDot(evt, element) {

            var charCode = (evt.which) ? evt.which : event.keyCode;

            if (charCode == 8){
                return true;
            }
            if (
                (charCode != 46 || $(element).val().indexOf('.') != -1) && // “.” CHECK DOT, AND ONLY ONE.
                (charCode < 48 || charCode > 57)){
                return false;
            }

            return true;
        }
});
</script>

@stop