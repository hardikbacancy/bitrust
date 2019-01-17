@extends('admin.adminlayout')

@section('page-header')
    Report
    <small>Loan Details</small>
    <meta name="csrf-token" content="{{ csrf_token() }}">

@stop

@section('content')
    <form method="POST" action="{{route(ADMIN.'.report.reportPost')}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
                <div class="col-md-4">
                    <label>Start Date</label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="start_date" value=""
                               placeholder="ENTER START DATE" name="start_date">
                    </div>
                </div>

                <div class="col-md-4">
                    <label>End Date</label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="end_date" value=""
                               placeholder="ENTER END DATE" name="end_date">
                    </div>
                </div>

            <div class="col-md-4">
                <button type="submit" class="btn btn-primary export-btn-custom">
                    {{ __('Export') }}
                </button>
            </div>
    </div>
    </form>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <table id="reportList" class="table data-tables table-striped table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Loan Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Loan Amount(in $)</th>
                            <th>EMI Period(in Month)</th>
                            <th>Interest Rate(In %)</th>
                            <th>Loan Amount(Including Interest in $)</th>
                            <th>EMI Amount(Per Month in $)</th>
                            <th>EMI Paid Amount(in $)</th>
                            <th>EMI Remainning Amount(in $)</th>
                            <th>Loan Status</th>
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
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#reportList').DataTable({
                processing: true,
                serverSide: true,
                "scrollX": true,
                "ajax": {
                    url: '{{route(ADMIN.'.report.reportPostAjax')}}',
                    type: 'POST',
                },
                columns: [
                    {data: 'loan_id', name: 'loan_id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'loan_amount', name: 'loan_amount', orderable: true},
                    {data: 'tenuar_period', name: 'tenuar_period'},
                    {data: 'interest_rate', name: 'interest_rate'},
                    {data: 'laon_amount_including_interest', name: 'laon_amount_including_interest', orderable: true},
                    {data: 'emi_amount', name: 'emi_amount'},
                    {data: 'paidEmiAmount', name: 'paidEmiAmount'},
                    {data: 'remainningEmiAmount', name: 'remainningEmiAmount', orderable: true},
                    {data: 'completed', name: 'completed'},
                ]
            });

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