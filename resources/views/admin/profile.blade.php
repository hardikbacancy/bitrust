@extends('admin.adminlayout')

@section('page-header')
  Profile <small>update</small>
@stop

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box" style="border:1px solid #d2d6de;">
        {!! Form::model($item, [
                'action' => ['ProfileController@update', $item->id],
                'id'=>'profile_update',
                'method' => 'put',
                'files' => true,

            ])
        !!}
        <div class="box-body" style="margin:10px;">
            {!! Form::myInput('text', 'name', 'Name <span>*</span>') !!}
            {!! Form::myInput('email', 'email', 'Email<span>*</span>') !!}
            {!! Form::myInput('mobile', 'mobile', 'Mobile<span>*</span>') !!}
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select class="form-control" id="gender" name="gender">
                    <option value="male" @if(isset($item)) @if($item['gender']=='male') selected @endif @endif>MALE</option>
                    <option value="female" @if(isset($item)) @if($item['gender']=='female') selected @endif @endif>FEMALE</option>
                </select>
            </div>
            {!! Form::myInput('password', 'password', 'Password') !!}
            {!! Form::myInput('password', 'password_confirmation', 'Password confirmation') !!}
            <div class="form-group">
                <label for="photo">Photo<span>*</span></label>
          <div class="col-md-12 pd-0 mt-10">
            <div class="col-md-3 pd-0">
                <div class="profile-file">
                    Browse
                    <input type="file" onchange="showProfileImage(this)" name="avatar" id="avatar" value="{{$item->avatar}}" />
                </div>
            </div>

            <div class="col-md-3">
                @if(isset($item->avatar))
                    <img class="user-profile" id="show_profile_img" src="{{$item->avatar}}" alt="image"/>
                @else
                    <img class="user-profile" id="show_profile_img" src="{{asset('img/avatar0.png')}}" alt="image"/>
                @endif
            </div>
          </div>
            </div>
        </div>

        <div class="box-footer" style="background-color:#f5f5f5;border-top:1px solid #d2d6de;">
      	  <button type="submit" class="btn btn-info" style="width:100px;">{{ trans('app.update_button') }}</button>
      	</div>

      {!! Form::close() !!}
    </div>
  </div>
</div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $('#profile_update').validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    mobile: {
                        required: true,
                        number: true,
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
        function showProfileImage(fileInput) {
            var files = fileInput.files;
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var imageType = /image.*/;
                if (!file.type.match(imageType)) {
                    continue;
                }
                var img = document.getElementById("show_profile_img");
                img.file = file;
                var reader = new FileReader();
                reader.onload = (function (aImg) {
                    return function (e) {
                        aImg.src = e.target.result;
                    };
                })(img);
                reader.readAsDataURL(file);
            }
        }
    </script>
    @stop