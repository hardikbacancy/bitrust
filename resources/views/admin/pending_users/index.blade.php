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
    Pending Users
    <small>{{ trans('app.manage') }}</small>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box" style="border:1px solid #d2d6de;">

                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table id="tbl" class="table data-tables table-striped table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th class='bool text-center'>Active</th>
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
                                <td>{{ $user->active }}</td>
                                <td class="actions">
                                    @if ( Auth::user()->rolename() === "Superadmin" || Auth::user()->role > $user->role)
                                        <ul class="list-inline" style="margin-bottom:0px;">
                                            <li><a href="{{ route(ADMIN . '.pending_users.edit', $user->id) }}"
                                                   title="{{ "Edit User" }}" class="btn btn-primary btn-xs"><i
                                                            class="fa fa-pencil"></i></a></li>
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
            renderBoolColumn('#tbl', 'bool');
        })(jQuery);
    </script>
@stop
