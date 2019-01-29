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
    Membership Details
    <small>{{ trans('app.manage') }}</small>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content')
    <div class="box-header" style="background-color:#f5f5f5;border-bottom:1px solid #d2d6de;">
        <div class="row">
            <div class="col-md-2">
        <label>User Email:</label>
            </div>
            <div class="col-md-4">
        {{$users->email}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <table id="membershipDetailList" class="table data-tables table-striped table-hover" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>Year</th>
                            <th>Total Fees(in $)</th>
                            <th>Total Penalty(in $)</th>
                            <th>Total Amount(fees including penalty in $)</th>
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
     var userId='{{$users['id']}}';
    $(document).ready(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#membershipDetailList').DataTable({
            oLanguage: {
                sProcessing: "<img src='{{asset('img/loading.gif')}}'>"
            },
            "order": [],
            processing: true,
            serverSide: true,
            "scrollX": true,
            "ajax": {
                url: '{{route(ADMIN.'.membership.membershipDetailsPostAjax')}}',
                type: 'POST',
                data:{'userId':userId}
            },
            columns: [
                {data: 'year', name: 'year'},
                {data: 'total_fees', name: 'total_fees'},
                {data: 'total_penalty', name: 'total_penalty'},
                {data: 'total_amount', name: 'total_amount'},
                {data: 'editDeleteAction', name: 'editDeleteAction',sClass:"test"},
            ]
        });
    });
    </script>
@stop
