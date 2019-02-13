@extends('auth.authlayout')

@section('content')

    <p class="login-box-msg"><b>Register</b> </p>
    @if (Session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
  <?php $val=str_random(40);  ?>
    <form role="form" method="POST" action="{{ url('/register') }}" id="reg_form">
        {{csrf_field()}}
        <input type="hidden" name="verification_code" value={{$val}}>
        <input type="hidden" name="active" value="0">
        <input type="hidden" name="email_verified_at" value="1">


        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} has-feedback">
            <input type="text" class="form-control" placeholder="Full name" name="name" value="{{ old('name') }}">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>

            @if ($errors->has('name'))
                    <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                    </span>
            @endif
        </div>


        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }} has-feedback">
            <input type="text" class="form-control" placeholder="User name" name="username" value="{{ old('username') }}">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>

            @if ($errors->has('username'))
                <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                    </span>
            @endif
        </div>



        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
            <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

            @if ($errors->has('email'))
                    <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                    </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }} has-feedback">
            <input type="text" class="form-control" placeholder="Mobile" name="mobile" value="{{ old('mobile') }}">
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>

            @if ($errors->has('mobile'))
                <span class="help-block">
                            <strong>{{ $errors->first('mobile') }}</strong>
                </span>
            @endif
        </div>


        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password" >
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>

            @if ($errors->has('password'))
                    <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                    </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} has-feedback">
            <input type="password" class="form-control" placeholder="Retype password" name="password_confirmation" >
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>

            @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
            @endif
        </div>
        <div class="row">
            <div class="col-xs-6">
               
            </div>
            <!-- /.col -->
            <div class="col-xs-6">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    <div class="row" style="margin:20px 0 10px 0px;">
      <a href="{{url('login')}}" class="text-center" >I already have a membership</a>
    </div>
@endsection
@section('js')
    <script>
        // $(document).ready(function () {
        //     $.validator.addMethod("alphanumeric", function(value, element) {
        //         return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
        //     },"wrong format");
        //     $('#reg_form').validate({ // initialize the plugin
        //         rules: {
        //             // name: {
        //             //     required: true
        //             // },
        //             // email: {
        //             //     required: true
        //             // },
        //             // mobile: {
        //             //     required: true,
        //             //     number: true,
        //             //     minlength:10,
        //             //     maxlength:10,
        //             //
        //             // },
        //             // password: {
        //             //     required: true,
        //             //     minlength: 6
        //             // },
        //             // password_confirmation: {
        //             //     required: true,
        //             //     equalTo : "#password"
        //             //
        //             // },
        //             username: {
        //                 alphanumeric: true,
        //             }
        //         },
        //
        //     });
        // });

    </script>

@stop
