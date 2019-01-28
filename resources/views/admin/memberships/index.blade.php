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
    Memberships
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
                            <button type="submit" class="btn btn-primary mt25">
                                {{ __('Filter') }}
                            </button>
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
                            <th>Id</th>
                            <th>User Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Year</th>
                            <th>Jan Fees</th>
                            <th>Jan Penalty</th>
                            <th>Feb Fees</th>
                            <th>Feb Penalty</th>
                            <th>March Fees</th>
                            <th>March Penalty</th>
                            <th>April Fees</th>
                            <th>April Penalty</th>
                            <th>May Fees</th>
                            <th>May Penalty</th>
                            <th>June Fees</th>
                            <th>June Penalty</th>
                            <th>July Fees</th>
                            <th>July Penalty</th>
                            <th>Aug Fees</th>
                            <th>Aug Penalty</th>
                            <th>Sep Fees</th>
                            <th>Sep Penalty</th>
                            <th>Oct Fees</th>
                            <th>Oct Penalty</th>
                            <th>Nov Fees</th>
                            <th>Nov Penalty</th>
                            <th>Dec Fees</th>
                            <th>Dec Penalty</th>
                            <th>Created Date</th>
                            <th>Updated Date</th>
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
            processing: true,
            serverSide: true,
            "scrollX": true,
            "ajax": {
                url: '{{route(ADMIN.'.membership.membershipPostAjax')}}',
                type: 'POST',
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'user_id', name: 'user_id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'year', name: 'year'},
                {data: 'jan_fees', name: 'jan_fees', orderable: true},
                {data: 'jan_penalty', name: 'jan_penalty'},
                {data: 'feb_fees', name: 'feb_fees'},
                {data: 'feb_penalty', name: 'feb_penalty', orderable: true},
                {data: 'march_fees', name: 'march_fees'},
                {data: 'march_penalty', name: 'march_penalty'},
                {data: 'april_fees', name: 'april_fees', orderable: true},
                {data: 'april_penalty', name: 'april_penalty'},
                {data: 'may_fees', name: 'may_fees', orderable: true},
                {data: 'may_penalty', name: 'may_penalty'},
                {data: 'june_fees', name: 'june_fees', orderable: true},
                {data: 'june_penalty', name: 'june_penalty'},
                {data: 'july_fees', name: 'july_fees', orderable: true},
                {data: 'july_penalty', name: 'july_penalty'},
                {data: 'aug_fees', name: 'aug_fees', orderable: true},
                {data: 'aug_penalty', name: 'aug_penalty'},
                {data: 'sep_fees', name: 'sep_fees', orderable: true},
                {data: 'sep_penalty', name: 'sep_penalty'},
                {data: 'oct_fees', name: 'oct_fees', orderable: true},
                {data: 'oct_penalty', name: 'oct_penalty'},
                {data: 'nov_fees', name: 'nov_fees', orderable: true},
                {data: 'nov_penalty', name: 'nov_penalty'},
                {data: 'dec_fees', name: 'dec_fees', orderable: true},
                {data: 'dec_penalty', name: 'dec_penalty'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
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
                    {data: 'id', name: 'id'},
                    {data: 'user_id', name: 'user_id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'year', name: 'year'},
                    {data: 'jan_fees', name: 'jan_fees', orderable: true},
                    {data: 'jan_penalty', name: 'jan_penalty'},
                    {data: 'feb_fees', name: 'feb_fees'},
                    {data: 'feb_penalty', name: 'feb_penalty', orderable: true},
                    {data: 'march_fees', name: 'march_fees'},
                    {data: 'march_penalty', name: 'march_penalty'},
                    {data: 'april_fees', name: 'april_fees', orderable: true},
                    {data: 'april_penalty', name: 'april_penalty'},
                    {data: 'may_fees', name: 'may_fees', orderable: true},
                    {data: 'may_penalty', name: 'may_penalty'},
                    {data: 'june_fees', name: 'june_fees', orderable: true},
                    {data: 'june_penalty', name: 'june_penalty'},
                    {data: 'july_fees', name: 'july_fees', orderable: true},
                    {data: 'july_penalty', name: 'july_penalty'},
                    {data: 'aug_fees', name: 'aug_fees', orderable: true},
                    {data: 'aug_penalty', name: 'aug_penalty'},
                    {data: 'sep_fees', name: 'sep_fees', orderable: true},
                    {data: 'sep_penalty', name: 'sep_penalty'},
                    {data: 'oct_fees', name: 'oct_fees', orderable: true},
                    {data: 'oct_penalty', name: 'oct_penalty'},
                    {data: 'nov_fees', name: 'nov_fees', orderable: true},
                    {data: 'nov_penalty', name: 'nov_penalty'},
                    {data: 'dec_fees', name: 'dec_fees', orderable: true},
                    {data: 'dec_penalty', name: 'dec_penalty'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'},
                    {data: 'editDeleteAction', name: 'editDeleteAction',sClass:"test"},
                ]
            });
        })
    });

    </script>
@stop
