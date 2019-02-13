@extends('admin.adminlayout')

@section('page-header')
  User <small>update</small>
@stop

@section('content')
<div class="row">
  <div class="col-sm-12">
    <div class="box" style="border:1px solid #d2d6de;">
        {!! Form::model($item, [
                'action' => ['UsersController@update', $item->id],
                'method' => 'put',
                'files' => true,
                'id' => 'update-user',
            ])
        !!}

        <div class="box-body" style="margin:10px;">
          @include('admin.users.form')
            <div class="form-group">
                <label for="photo">Photo  &nbsp;(Allow only jpeg,bmp,png up to 2MB)<span>*</span>:</label>
                <div class="col-md-12 pd-0 mt-10">
                    <div class="col-md-3 pd-0">
                        <div class="profile-file">
                            Browse
                            <input type="file" onchange="showProfileImage(this)" name="avatar" id="avatar" value="" />
                        </div>
                    </div>

                    <div class="col-md-3">
                        <img class="user-profile" id="show_profile_img" src="{{$item->avatar}}" alt="image"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-footer" style="background-color:#f5f5f5;border-top:1px solid #d2d6de;">
      	  <button type="submit" class="btn btn-info" style="width:100px;">{{ trans('app.update_button') }}</button>
          <a class="btn btn-warning " href="{{ route(ADMIN.'.users.index') }}" style="width:100px;"><i class="fa fa-btn fa-back"></i>Cancel</a>
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
                    address: {
                        required: true,
                    },
                    birthdate: {
                        required: true,
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