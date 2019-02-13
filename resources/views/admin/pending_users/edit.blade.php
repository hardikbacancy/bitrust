@extends('admin.adminlayout')

@section('page-header')
  Pending User <small>update</small>
@stop

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box" style="border:1px solid #d2d6de;">
        {!! Form::model($item, [
                'action' => ['PendingUsersController@update', $item->id],
                'method' => 'put',
                'files' => true,
                'id' => 'update-user',
            ])
        !!}

        <div class="box-body" style="margin:10px;">
          @include('admin.pending_users.form')
        </div>

        <div class="box-footer" style="background-color:#f5f5f5;border-top:1px solid #d2d6de;">
      	  <button type="submit" class="btn btn-info" style="width:100px;">{{ trans('app.update_button') }}</button>
          <a class="btn btn-warning " href="{{ route(ADMIN.'.pending_users.index') }}" style="width:100px;"><i class="fa fa-btn fa-back"></i>Cancel</a>
      	</div>

      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop
@section('js')


    <script>
        $(document).ready(function () {
            $('#update-user').validate({ // initialize the plugin
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    mobile: {
                        required: true,
                        digits: true,
                        minlength:10,
                        maxlength:10,
                    },
                    password: {
                        minlength: 6
                    },
                    password_confirmation: {
                        equalTo : "#password"

                    },
                }
            });
        });

    </script>

@stop