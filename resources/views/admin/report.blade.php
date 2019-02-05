@extends('admin.adminlayout')

@section('page-header')
    Report
    <small>Loan Details</small>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content')
    <form id="reportListSubmit">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="row">
            <div class="col-md-4">
                <label>Start Date</label>
                <div class="form-group">
                    <input type="text" class="form-control" id="start_date" value=""
                           placeholder="ENTER START DATE" name="start_date" readonly='true'>
                </div>
            </div>

            <div class="col-md-4">
                <label>End Date</label>
                <div class="form-group">
                    <input type="text" class="form-control" id="end_date" value=""
                           placeholder="ENTER END DATE" name="end_date" readonly='true'>
                </div>
            </div>

            <div class="col-md-4">
                <button type="submit" class="btn btn-primary export-btn-custom">
                    {{ __('Filter') }}
                </button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <table id="reportList" class="table data-tables table-striped table-hover" cellspacing="0"
                           width="100%">
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
                            <th>Created Date</th>
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#reportList').DataTable({
                oLanguage: {
                    sProcessing: "<img src='{{asset('img/loading.gif')}}'>"
                },
                "order": [],
                processing: true,
                serverSide: true,
                "scrollX": true,
                "dom": 'Bfrtip',
                buttons: [
                    'csv', 'excel'
                ],
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
                    {data: 'created_date', name: 'created_date'},
                ]
            });
            $("#reportListSubmit").submit(function (e) {
                e.preventDefault();
                var start_date = $("#start_date").val();
                var end_date = $("#end_date").val();

                $.ajax({
                    url: '{{route(ADMIN.'.checkData')}}',
                    data: {'start_date': start_date, 'end_date': end_date, "_token": "{{csrf_token()}}"},
                    dataType: 'json',
                    type: 'post',
                    success: function (res) {

                        if (res.length > 0) {
                            $('#reportList').DataTable({
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
                                    'csv', 'excel'
                                ],
                                "ajax": {
                                    url: '{{route(ADMIN.'.report.reportPostAjax')}}',
                                    type: 'POST',
                                    data: {'start_date': start_date, 'end_date': end_date},
                                },
                                columns: [
                                    {data: 'loan_id', name: 'loan_id'},
                                    {data: 'name', name: 'name'},
                                    {data: 'email', name: 'email'},
                                    {data: 'loan_amount', name: 'loan_amount', orderable: true},
                                    {data: 'tenuar_period', name: 'tenuar_period'},
                                    {data: 'interest_rate', name: 'interest_rate'},
                                    {
                                        data: 'laon_amount_including_interest',
                                        name: 'laon_amount_including_interest',
                                        orderable: true
                                    },
                                    {data: 'emi_amount', name: 'emi_amount'},
                                    {data: 'paidEmiAmount', name: 'paidEmiAmount'},
                                    {data: 'remainningEmiAmount', name: 'remainningEmiAmount', orderable: true},
                                    {data: 'completed', name: 'completed'},
                                    {data: 'created_date', name: 'created_date'},

                                ]
                            });

                        }
                        else {
                            $('#reportList').DataTable({
                                oLanguage: {
                                    sProcessing: "<img src='{{asset('img/loading.gif')}}'>"
                                },
                                "order": [],
                                processing: true,
                                serverSide: true,
                                "scrollX": true,
                                "bDestroy": true,
                                "ajax": {
                                    url: '{{route(ADMIN.'.report.reportPostAjax')}}',
                                    type: 'POST',
                                    data: {'start_date': start_date, 'end_date': end_date},
                                },
                                columns: [
                                    {data: 'loan_id', name: 'loan_id'},
                                    {data: 'name', name: 'name'},
                                    {data: 'email', name: 'email'},
                                    {data: 'loan_amount', name: 'loan_amount', orderable: true},
                                    {data: 'tenuar_period', name: 'tenuar_period'},
                                    {data: 'interest_rate', name: 'interest_rate'},
                                    {
                                        data: 'laon_amount_including_interest',
                                        name: 'laon_amount_including_interest',
                                        orderable: true
                                    },
                                    {data: 'emi_amount', name: 'emi_amount'},
                                    {data: 'paidEmiAmount', name: 'paidEmiAmount'},
                                    {data: 'remainningEmiAmount', name: 'remainningEmiAmount', orderable: true},
                                    {data: 'completed', name: 'completed'},
                                    {data: 'created_date', name: 'created_date'},

                                ]
                            });

                        }
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