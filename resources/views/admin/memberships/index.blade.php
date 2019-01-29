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
        <div class="col-xs-12">
            <div class="box" style="border:1px solid #d2d6de;">
                <div class="box-header" style="background-color:#f5f5f5;border-bottom:1px solid #d2d6de;">
<form id="member-filter">
                    <div class="row">

                        <div class="col-md-3">
                    <div class="form-group">
                        <label for="user_id">Select User:</label>
                        <select class="form-control" id="user_id" name="user_id">
                            <option value="">Select User</option>;
                            @foreach($userDetails as $userDetail)
                                <option value="{{$userDetail['id']}}">{{$userDetail['email']}}</option>
                            @endforeach
                        </select>
                    </div>
                        </div>
                        <div class="col-md-3">
                    <div class="form-group mb30">
                        <label for="year">Select Year:</label>
                        <select class="form-control" id="year" name="year">
                            <option value="">Select Year</option>;
                            <?php

                            for($i=2000;$i<=date('Y');$i++)
                            {
                                echo '<option value='.$i.'>'.$i.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                        </div>

                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-4">
                            <button type="submit" class="btn btn-primary mt25">
                                {{ __('Filter') }}
                            </button>
                                </div>
                                <div class="col-md-4">
                            <button type="submit" id="reset" class="btn btn-primary mt25">
                                {{ __('Reset') }}
                            </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mt25">
                            <a class="btn btn-info pull-right" href="{{ route(ADMIN . '.membership.create') }}" title="Add Membership">
                                <i class="fa fa-plus" style="vertical-align:middle"></i> Add Membership
                            </a>
                        </div>
                    </div>
</form>
                </div>

            </div>
        </div>
    </div>
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
    $(document).ready(function (e) {
        $("#user_id").select2();
        $("#year").select2();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#membershipList').DataTable({
            oLanguage: {
                sProcessing: "<img src='{{asset('img/loading.gif')}}'>"
            },
            "order": [],
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
                {data: 'year', name: 'year'},
                {data: 'total_fees', name: 'total_fees'},
                {data: 'total_penalty', name: 'total_penalty'},
                {data: 'total_amount', name: 'total_amount'},
                {data: 'editDeleteAction', name: 'editDeleteAction',sClass:"test"},
            ]
        });
        $(document.body).on('click', '.delete-member', function () {
            var obj = $(this);
            var memberId = $(this).attr('data-memberId');
            swal({
                title: 'Are you sure?',
                type: 'error',
                showCancelButton: true,
                confirmButtonColor: '#DD4B39',
                cancelButtonColor: '#00C0EF',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                closeOnConfirm: false
            }).catch(swal.noop).then(function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '{{route(ADMIN.'.membership.deleteMemberAjax')}}',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            memberId: memberId,
                        },
                        success: function (response) {
                            $('#membershipList').DataTable().ajax.reload(null, false);
                            notification("Deleted successfully.!", "success");
                        }
                    });
                }
            });
        });
        $("#member-filter").submit(function (e) {
            e.preventDefault();
            var user = $("#user_id").val();
            var year = $("#year").val();

            $('#membershipList').DataTable({
                oLanguage: {
                    sProcessing: "<img src='{{asset('img/loading.gif')}}'>"
                },
                "order": [],
                processing: true,
                serverSide: true,
                "scrollX": true,
                "bDestroy": true,
                "ajax": {
                    url: '{{route(ADMIN.'.membership.membershipPostAjax')}}',
                    type: 'POST',
                    data: {'user': user, 'year': year},
                },
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'year', name: 'year'},
                    {data: 'total_fees', name: 'total_fees'},
                    {data: 'total_penalty', name: 'total_penalty'},
                    {data: 'total_amount', name: 'total_amount'},
                    {data: 'editDeleteAction', name: 'editDeleteAction',sClass:"test"},
                ]
            });
        })
        $("#reset").click(function (e) {
            e.preventDefault();
            $('#year').val('').trigger('change');
            $('#user_id').val('').trigger('change');
            $('#membershipList').DataTable({
                oLanguage: {
                    sProcessing: "<img src='{{asset('img/loading.gif')}}'>"
                },
                "order": [],
                processing: true,
                serverSide: true,
                "scrollX": true,
                "bDestroy": true,
                "ajax": {
                    url: '{{route(ADMIN.'.membership.membershipPostAjax')}}',
                    type: 'POST',
                },
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'year', name: 'year'},
                    {data: 'total_fees', name: 'total_fees'},
                    {data: 'total_penalty', name: 'total_penalty'},
                    {data: 'total_amount', name: 'total_amount'},
                    {data: 'editDeleteAction', name: 'editDeleteAction',sClass:"test"},
                ]
            });
        });
    });
    </script>
@stop
