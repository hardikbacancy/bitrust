@extends('admin.adminlayout')

@section('page-header')
    Report
    <small>Loan Details</small>
@stop

@section('content')
    <form method="POST" action="/admin/report">
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

    {{--<div class="row">--}}
        {{--<div class="col-md-12">--}}
            {{--<div class="panel panel-white">--}}
                {{--<div class="panel-body">--}}
                    {{--<table id="reportList" class="display nowrap" cellspacing="0" width="100%">--}}
                        {{--<thead>--}}
                        {{--<tr>--}}
                            {{--<th></th>--}}
                            {{--<th>Session Type</th>--}}
                            {{--<th>Title</th>--}}
                            {{--<th>Start date</th>--}}
                            {{--<th>End date</th>--}}
                            {{--<th>All dates</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
@stop
@section('js')
    <script>
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
    </script>
@stop