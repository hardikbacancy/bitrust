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
    Expense
    <small>{{ trans('app.manage') }}</small>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <a class="btn btn-info" href="{{ route(ADMIN . '.expense.create') }}" title="Create Expense">
        <i class="fa fa-plus" style="vertical-align:middle"></i> Create Expense
    </a>

@stop

@section('content')
    <div class="box-header" style="background-color:#f5f5f5;border-bottom:1px solid #d2d6de;">

        <div class="row">

            <div class="col-md-3">
                <div class="form-group">
                    <label for="user_id">Expense Type</label>
                    <select class="form-control" id="expense_id" name="expense_id">
                         <option value="">--Select Expense--</option>;
                            @foreach($expenses as $expense)
                                <option value={{$expense['id']}}>{{$expense['expense_type']}}</option>;
                            @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb30">
                    <label for="year">Year</label>
                    <select class="form-control" id="year" name="year">
                        <option value="">--Select Year--</option>;
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
                <div class="form-group mb30">
                    <label for="year">Select Month</label>
                    <select class="form-control" id="month" name="month">
                           <option value="">--Select Year--</option>;
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                    </select>
                </div>
            </div>

            <div class="col-md-1">
                <button type="button" class="btn btn-primary mt25" id="expense-filter-button">
                    {{ __('Filter') }}
                </button>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-primary mt25" id="expense-reset-button">
                    {{ __('Reset') }}
                </button>
            </div>

        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <table id="expenseList" class="table data-tables table-striped table-hover" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>Expense Type</th>
                            <th>Year</th>
                            <th>Month</th>
                            <th>Expense</th>
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

    <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>--}}
    <script src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function (e) {
            $("#expense_id").select2();
            $("#year").select2();
            $("#month").select2();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#expenseList').DataTable({
                oLanguage: {
                    sProcessing: "<img src='{{asset('img/loading.gif')}}'>"
                },
                processing: true,
                serverSide: true,
                "scrollX": true,
                "dom": 'Bfrtip',
                buttons: [
                    'excel'
                ],
                "ajax": {
                    url: '{{route(ADMIN.'.expense.expensePostAjax')}}',
                    type: 'POST',
                },
                columns: [
                    {data: 'expense_type', name: 'expense_type'},
                    {data: 'year', name: 'year'},
                    {data: 'month', name: 'month'},
                    {data: 'expense', name: 'expense'},
                    {data: 'editDeleteAction', name: 'editDeleteAction'},
                ]
            });

            $("#expense-filter-button").click(function (e) {
                e.preventDefault();
                var expense_id = $("#expense_id").val();
                var year = $("#year").val();
                var month = $("#month").val();
                $('#expenseList').DataTable({
                    oLanguage: {
                        sProcessing: "<img src='{{asset('img/loading.gif')}}'>"
                    },
                    processing: true,
                    serverSide: true,
                    "scrollX": true,
                    "bDestroy": true,
                    "dom": 'Bfrtip',
                    buttons: [
                        'excel'
                    ],
                    "ajax": {
                        url: '{{route(ADMIN.'.expense.expensePostAjax')}}',
                        type: 'POST',
                        data: {'expense_id': expense_id, 'year': year,'month': month},
                    },
                    columns: [
                        {data: 'expense_type', name: 'expense_type'},
                        {data: 'year', name: 'year'},
                        {data: 'month', name: 'month'},
                        {data: 'expense', name: 'expense'},
                        {data: 'editDeleteAction', name: 'editDeleteAction'},
                    ]
                });
            })
            $("#expense-reset-button").click(function (e) {
                e.preventDefault();
                $('#expense_id').val('').trigger('change');
                $('#year').val('').trigger('change');
                $('#month').val('').trigger('change');
                $('#expenseList').DataTable({
                    oLanguage: {
                        sProcessing: "<img src='{{asset('img/loading.gif')}}'>"
                    },
                    "order": [],
                    processing: true,
                    serverSide: true,
                    "scrollX": true,
                    "bDestroy": true,
                    "ajax": {
                        url: '{{route(ADMIN.'.expense.expensePostAjax')}}',
                        type: 'POST',
                    },
                    columns: [
                        {data: 'expense_type', name: 'expense_type'},
                        {data: 'year', name: 'year'},
                        {data: 'month', name: 'month'},
                        {data: 'expense', name: 'expense'},
                        {data: 'editDeleteAction', name: 'editDeleteAction'},
                    ]
                });
            });

            $(document.body).on('click', '.delete-expense', function () {
                var obj = $(this);
                var expenseId = $(this).attr('data-expenseId');

                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function(isConfirm) {
                    $.ajax({
                        url: '{{route(ADMIN.'.expense.delete')}}',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            expenseId: expenseId,
                        },
                        success: function (response) {
                            notification("Removed Successfully!",'success');
                            $('#expenseList').DataTable().ajax.reload(null, false);

                        }
                    });
                });
            });

        });
    </script>
@stop
