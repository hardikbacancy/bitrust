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
                    {data: 'editDeleteAction', name: 'editDeleteAction',sClass:"test"},
                ]
            });
        });
    });
    </script>
@stop
