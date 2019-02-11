@extends('admin.adminlayout')

@section('css')

@stop

@section('page-header')
    Loan Profit History
    <small>{{ trans('app.manage') }}</small>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content')

    <div class="box-header" style="background-color:#f5f5f5;border-bottom:1px solid #d2d6de;">

        <div class="row">
            <h5 style="margin-left: 20px;">Total Loan Profit Amount ( Interest amount including penalty in $ ) : &nbsp;&nbsp;<span id="profit_amount_value"></span></h5> <br>
            <div class="col-md-4">
                <label>EMI Paid Start Date</label>
                <div class="form-group">
                    <input type="text" class="form-control" id="start_date" value=""
                           placeholder="ENTER START DATE" name="start_date" readonly='true'>
                </div>
            </div>

            <div class="col-md-4">
                <label>EMI Paid End Date</label>
                <div class="form-group">
                    <input type="text" class="form-control" id="end_date" value=""
                           placeholder="ENTER END DATE" name="end_date" readonly='true'>
                </div>
            </div>


            <div class="col-md-1">
                <button type="button" class="btn btn-primary mt25" id="emi-filter-button">
                    {{ __('Filter') }}
                </button>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-primary mt25" id="emi-reset-button">
                    {{ __('Reset') }}
                </button>
            </div>

        </div>

    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <table id="loanProfitList" class="table data-tables table-striped table-hover" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>Loan EMI Id</th>
                            <th>Loan Id</th>
                            <th>User Email</th>
                            <th>Amount Per Month(in $)</th>
                            <th>EMI Amount(in $)</th>
                            <th>Interest Amount(in $)</th>
                            <th>Penalty(in $)</th>
                            <th>EMI Date</th>
                            <th>EMI Paid Date</th>
                            <th>Profit(in $)</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <a class="btn btn-warning" href="{{ URL::previous() }}" style="width:100px;"><i class="fa fa-btn fa-back"></i>Cancel</a>
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
            $('#loanProfitList').DataTable({
                oLanguage: {
                    sProcessing: "<img src='{{asset('img/loading.gif')}}'>"
                },
                order:[],
                processing: true,
                serverSide: true,
                "scrollX": true,
                "ajax": {
                    url: '{{route(ADMIN.'.loanProfit.loanProfitPostAjax')}}',
                    type: 'POST',
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'request_id', name: 'request_id'},
                    {data: 'email', name: 'email'},
                    {data: 'amount_per_month', name: 'amount_per_month'},
                    {data: 'emi_amount', name: 'emi_amount'},
                    {data: 'interest_amount', name: 'interest_amount'},
                    {data: 'penalty', name: 'penalty'},
                    {data: 'tenuar_date', name: 'tenuar_date'},
                    {data: 'emi_paid_date', name: 'emi_paid_date'},
                    {data: 'profit_amount', name: 'profit_amount'},
                ],
                "initComplete":function(settings, json){
                    var profit_amount_val=0;
                    json.data.forEach(function (value, index) {
                        profit_amount_val=profit_amount_val+value.profit_amount;
                    });
                    $("#profit_amount_value").html(profit_amount_val);
                }
            });


            $("#emi-filter-button").click(function (e) {
                e.preventDefault();
                var start_date = $("#start_date").val();
                var end_date = $("#end_date").val();
                $('#loanProfitList').DataTable({
                    oLanguage: {
                        sProcessing: "<img src='{{asset('img/loading.gif')}}'>"
                    },
                    processing: true,
                    serverSide: true,
                    "scrollX": true,
                    "bDestroy": true,
                    "ajax": {
                        url: '{{route(ADMIN.'.loanProfit.loanProfitPostAjax')}}',
                        type: 'POST',
                        data: {'start_date': start_date, 'end_date': end_date},
                    },
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'request_id', name: 'request_id'},
                        {data: 'email', name: 'email'},
                        {data: 'amount_per_month', name: 'amount_per_month'},
                        {data: 'emi_amount', name: 'emi_amount'},
                        {data: 'interest_amount', name: 'interest_amount'},
                        {data: 'penalty', name: 'penalty'},
                        {data: 'tenuar_date', name: 'tenuar_date'},
                        {data: 'emi_paid_date', name: 'emi_paid_date'},
                        {data: 'profit_amount', name: 'profit_amount'},
                    ],
                    "initComplete":function(settings, json){
                        var profit_amount_val=0;
                        json.data.forEach(function (value, index) {
                            profit_amount_val=profit_amount_val+value.profit_amount;
                        });
                        $("#profit_amount_value").html(profit_amount_val);
                    }
                });
            })

            $("#emi-reset-button").click(function (e) {
                e.preventDefault();
                $("#start_date").val('');
                $("#end_date").val('');
                $('#loanProfitList').DataTable({
                    oLanguage: {
                        sProcessing: "<img src='{{asset('img/loading.gif')}}'>"
                    },
                    processing: true,
                    serverSide: true,
                    "scrollX": true,
                    "bDestroy": true,
                    "ajax": {
                        url: '{{route(ADMIN.'.loanProfit.loanProfitPostAjax')}}',
                        type: 'POST',
                    },
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'request_id', name: 'request_id'},
                        {data: 'email', name: 'email'},
                        {data: 'amount_per_month', name: 'amount_per_month'},
                        {data: 'emi_amount', name: 'emi_amount'},
                        {data: 'interest_amount', name: 'interest_amount'},
                        {data: 'penalty', name: 'penalty'},
                        {data: 'tenuar_date', name: 'tenuar_date'},
                        {data: 'emi_paid_date', name: 'emi_paid_date'},
                        {data: 'profit_amount', name: 'profit_amount'},
                    ],
                    "initComplete":function(settings, json){
                        var profit_amount_val=0;
                        json.data.forEach(function (value, index) {
                            profit_amount_val=profit_amount_val+value.profit_amount;
                        });
                        $("#profit_amount_value").html(profit_amount_val);
                    }
                });
            })




            $('#start_date').val('');
            $('#end_date').val('');
            $('#start_date').datepicker({
                format: "dd-mm-yyyy",
                viewMode: "month",
                minViewMode: "month",
                orientation: "top"
            }).on('changeDate', function (selected) {
                startDate = new Date(selected.date.valueOf());
                startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
                $('#end_date').datepicker('setStartDate', startDate);
            });
            $('#end_date').datepicker({
                format: "dd-mm-yyyy",
                viewMode: "month",
                minViewMode: "month",
                orientation: "top"
            }).on('changeDate', function (selected) {
                startDate = new Date(selected.date.valueOf());
                startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
                $('#end_date').datepicker('setStartDate', startDate);
            });
        });
    </script>
@stop
