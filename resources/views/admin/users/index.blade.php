@extends('admin.adminlayout')

@section('css')
    <style>
        table.table .actions {
            width: 100px;
            text-align: center;
        }
    </style>
@stop

@section('page-header')
    Users
    <small>{{ trans('app.manage') }}</small>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box" style="border:1px solid #d2d6de;">
                <div class="box-header" style="background-color:#f5f5f5;border-bottom:1px solid #d2d6de;">

                    <a class="btn btn-info" href="{{ route(ADMIN . '.users.create') }}" title="Add User">
                        <i class="fa fa-plus" style="vertical-align:middle"></i> Add User
                    </a>

                </div>

                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table id="tbl" class="table data-tables table-striped table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            {{--<th>Role</th>--}}
                            <th class='bool text-center'>Active</th>
                            {{--<th class='bool text-center'>Email Verified</th>--}}
                            <th class="no-sort">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobile }}</td>
                                {{--<td>{{ Helper::getRolename($user->role)  }}</td>--}}
                                {{--<td>{{ $user->active }}</td>--}}
                                <td><div class="text-center text-success"><span class="fa fa-check-circle"></span></div></td>
                                {{--<td>{{ $user->email_verified_at }}</td>--}}
                                <td class="actions">
                                    @if ( Auth::user()->rolename() === "Superadmin" || Auth::user()->role > $user->role)
                                        <ul class="list-inline" style="margin-bottom:0px;">

                                            <li><a href="{{ route(ADMIN . '.membership.create',$user->id) }}"
                                                   title="{{ "Add Membership" }}" class="btn btn-primary btn-xs"><i
                                                            class="fa fa-plus-square"></i></a></li>
                                            <li>


                                            <li><a href="{{ route(ADMIN . '.users.edit', $user->id) }}"
                                                   title="{{ "Edit User" }}" class="btn btn-primary btn-xs"><i
                                                            class="fa fa-pencil"></i></a></li>
                                            {{--<li>--}}
                                                {{--{!! Form::open([--}}
                                                    {{--'class'=>'delete',--}}
                                                    {{--'url'  => route(ADMIN . '.users.destroy', $user->id),--}}
                                                    {{--'method' => 'DELETE',--}}
                                                    {{--])--}}
                                                {{--!!}--}}

                                                {{--<button class="btn btn-danger btn-xs"--}}
                                                        {{--title="{{ trans('app.delete_title') }}"><i--}}
                                                            {{--class="fa fa-trash"></i></button>--}}

                                                {{--{!! Form::close() !!}--}}
                                            {{--</li>--}}
                                        </ul>
                                    @elseif (Auth::user()->id === $user->id)
                                        <ul class="list-inline" style="margin-bottom:0px;">
                                            <li>
                                                <a href="{{ url('admin\profileedit', auth()->id()) }}"
                                                   title="Update Profile" class="btn btn-primary btn-xs"><i
                                                            class="fa fa-user"></i></a></li>
                                            </li>
                                        </ul>
                                    @else
                                        <i class="fa fa-ban" title="Forbidden" style="color:red;"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop

@section('js')
    <script>
        (function ($) {
            var table = $('.data-tables').DataTable({
                "columnDefs": [{
                    "targets": 'no-sort',
                }],
                "order": []
            });
            //replace bool column to checkbox
            //renderBoolColumn('#tbl', 'bool');
        })(jQuery);
    </script>
@stop
