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

    <form id="searchRecord">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
           
            <div class="col-md-2">
                <label>Name</label>
                <div class="form-group">
                    <input type="text" class="form-control" id="name" value=""
                           placeholder="Name" name="name" >
                </div>
            </div>

            <div class="col-md-2">
                <label>Email</label>
                <div class="form-group">
                    <input type="text" class="form-control" id="email" value=""
                           placeholder="Email" name="email" >
                </div>
            </div>

            <div class="col-md-2">
                <label>Phone</label>
                <div class="form-group">
                    <input type="text" class="form-control" id="phone" value=""
                           placeholder="Phone" name="phone" >
                </div>
            </div>


            <div class="col-md-1">
                <button type="submit" class="btn btn-primary export-btn-custom">
                    {{ __('Search') }}
                </button>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary mt25" id="reset-button">
                    {{ __('Reset') }}
                </button>
            </div>

        </div>
    </form>

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
                            <th>Mobile</th>
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
            searching:false,
            "scrollX": true,
            "ajax": {
                url: '{{route(ADMIN.'.membership.membershipPostAjax')}}',
                type: 'POST',
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'mobile', name: 'mobile'},
                {data: 'editDeleteAction', name: 'editDeleteAction',sClass:"test"},
            ]
        });

        /* Search AJAX request */
        $("#searchRecord").submit(function (e) {
                console.log('search');
                e.preventDefault();
                var name = $("#name").val();
                var email = $("#email").val();
                var phone = $("#phone").val();

                $('#membershipList').DataTable({
                    oLanguage: {
                        sProcessing: "<img src='{{asset('img/loading.gif')}}'>"
                    },
                    "order": [],
                    processing: true,
                    serverSide: true,
                    "scrollX": true,
                    "bDestroy": true,
                    searching: false,
                    dom: 'Bfrtip',
                    buttons: [
                       'excel'
                    ],
                    "ajax": {
                        url: '{{route(ADMIN.'.membership.membershipPostAjax')}}',
                        type: 'POST',
                        data: {'name':name,'email':email,'phone':phone},
                    },
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'email', name: 'email'},
                        {data: 'mobile', name: 'mobile'},
                        {data: 'editDeleteAction', name: 'editDeleteAction',sClass:"test"},

                    ]
                });

            })

        /* End */

        /* Reset filter code  */
        $("#reset-button").click(function (e) {
            e.preventDefault();
            $('#name').val('').trigger('change');
            $('#email').val('').trigger('change');
            $('#phone').val('').trigger('change');
                  
                $('#membershipList').DataTable({
                    oLanguage: {
                        sProcessing: "<img src='{{asset('img/loading.gif')}}'>"
                    },
                    "order": [],
                    processing: true,
                    serverSide: true,
                    "scrollX": true,
                    "bDestroy": true,
                    dom: 'Bfrtip',
                    buttons: [
                       'excel'
                    ],
                    "ajax": {
                        url: '{{route(ADMIN.'.membership.membershipPostAjax')}}',
                        type: 'POST',                           
                    },
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'email', name: 'email'},
                        {data: 'mobile', name: 'mobile'},
                        {data: 'editDeleteAction', name: 'editDeleteAction',sClass:"test"},

                    ]
                });
        });
        /* End reset filter code */

    });
    </script>
@stop
