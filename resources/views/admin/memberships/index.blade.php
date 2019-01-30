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
    Membership
    <small>{{ trans('app.manage') }}</small>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <table id="membershipList" class="table data-tables table-striped table-hover" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
    $(document).ready(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#membershipList').DataTable({
            oLanguage: {
                sProcessing: "<img src='{{asset('img/loading.gif')}}'>"
            },
            processing: true,
            serverSide: true,
            "scrollX": true,
            "ajax": {
                url: '{{route(ADMIN.'.membership.membershipPostAjax')}}',
                type: 'POST',
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'editDeleteAction', name: 'editDeleteAction',sClass:"test"},
            ]
        });

    });
    </script>
@stop
