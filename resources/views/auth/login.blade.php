@extends('auth.authlayout')

@section('content')

    <p class="login-box-msg"><b>Please Sign in</b></p>

    @if (Session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if (Session::has('warning'))
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <ul class="list-unstyled">
              <li>{{ Session::get('warning') }}</li>
            </ul>
        </div>
    @endif

    <form role="form" method="POST" action="{{ url('/login') }}">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }} has-feedback">
            <input type="text" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>

            @if ($errors->has('username'))
                    <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                    </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            @if ($errors->has('password'))
                    <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                    </span>
            @endif
        </div>

        <div class="row" style="margin-top:30px;margin-bottom:20px;">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('app.login_btn') }}</button>
            </div>
            <!-- /.col -->
        </div>


    </form>
    <div class="row">
        <div class="col-xs-6">
            <a href="{{ url('/register') }}">Register</a>
        </div><!-- /.col -->
        <div class="col-xs-6">
            <a href="{{ url('/password/reset') }}" class="text-right pull-right">Forgot Password</a>
        </div><!-- /.col -->
    </div>

@endsection
