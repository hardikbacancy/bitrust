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
                "order": [],
                processing: true,
                serverSide: true,
                searching: false,
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
                    "order": [],
                    processing: true,
                    serverSide: true,
                    searching: false,
                    "scrollX": true,
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
        });
    </script>
@stop
