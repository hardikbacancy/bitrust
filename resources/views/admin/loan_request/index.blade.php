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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    Loan Request
    <small>{{ trans('app.manage') }}</small>
    <meta name="csrf-token" content="{{ csrf_token() }}">

@stop
@section('content')
    @if(session()->has('message'))
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {!! session('message') !!}
        </div>
    @endif
    <div class="row">
        <div class="col-xs-12">
            <div class="box" style="border:1px solid #d2d6de;">
                <div class="box-header" style="background-color:#f5f5f5;border-bottom:1px solid #d2d6de;">
                    @if(\Auth::user()->role!='0')

                        <a class="btn btn-info" href="{{ route(ADMIN . '.loan_request.create') }}" title="Create Loan">
                            <i class="fa fa-plus" style="vertical-align:middle"></i> Create Loan
                        </a>
                    @else
                        @if($count>0)
                            <a class="btn btn-info" href="{{ route(ADMIN . '.loan_request.create') }}"
                               title="Create Loan">
                                <i class="fa fa-plus" style="vertical-align:middle"></i> Create Loan
                            </a>
                        @else
                            <a class="btn btn-info" title="Create Loan">
                                <i class="fa fa-plus" style="vertical-align:middle"></i> Create Loan
                            </a>
                            <span style="color:red;padding: 30px;"> {{"You do not have membership yet"}} </span>
                        @endif
                    @endif
                    <p><i class="material-icons" style="font-size:20px;color:red">error</i> <span style="color: red;">Click to See Pending EMI Below</span>
                    </p>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table id="tbl" class="table data-tables table-striped table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Loan Amount(in $)</th>
                            <th>EMI Period(in Month)</th>
                            <th>Interest Rate(in %)</th>
                            <th>Loan Amount(Including Interest in $)</th>
                            <th>EMI Paid Amount(in $)</th>
                            <th>EMI Remainning Amount(in $)</th>
                            <th>Loan Status</th>
                            <th class='bool text-center'>Request Status</th>
                            <th class="no-sort">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($loanRequest as $loanRequests)
                            <tr>
                                <td>{{$loanRequests['name']}}</td>
                                <td>{{$loanRequests['loan_amount']}}</td>
                                <td>{{$loanRequests['tenuar_period']}}</td>
                                <td>{{$loanRequests['interest_rate']}} </td>
                                <td>{{floor($loanRequests['loan_amount']*$loanRequests['interest_rate']/100+$loanRequests['loan_amount'])}}</td>
                                <td>{{$loanRequests['paidEmiAmount']}}</td>
                                <td>{{$loanRequests['remainningEmiAmount']}}</td>
                                <td>{{$loanRequests['completed']}}</td>
                                <td>{{$loanRequests['request_status']}}</td>
                                <td class="actions">
                                    <ul class="list-inline" style="margin-bottom: 0px;
    position: relative;">

                                        @if($loanRequests['request_status']=='1')
                                            <li>
                                                <a href="{{route(ADMIN . '.loan_request.loan_details', $loanRequests['id'])}}"
                                                   title="{{ "View Details" }}" class="btn btn-primary btn-xs"><i
                                                            class="fa fa-eye"></i>
                                                </a>
                                            </li>

                                            @if($loanRequests['emi_count']>0)

                                                <li style="position: absolute;right: -20px;top: -6px;">
                                                    <a data-toggle="modal" data-target="#emiPendingModel"
                                                       data-requestId="{{$loanRequests['id']}}"
                                                       title="{{ "View Pending Loan" }}"
                                                       class="btn emi-pending-click"><i class="material-icons"
                                                                                        style="font-size:20px;color:red">error</i>
                                                    </a>
                                                </li>
                                            @endif





                                            {{--@if (auth()->user()->hasRole('Superadmin|Admin'))--}}
                                            {{--<li>--}}
                                            {{--{!! Form::open([--}}
                                            {{--'class'=>'delete',--}}
                                            {{--'url'  => route(ADMIN . '.loan_request.destroy', $loanRequests['id']),--}}
                                            {{--'method' => 'DELETE',--}}
                                            {{--])--}}
                                            {{--!!}--}}

                                            {{--<button class="btn btn-danger btn-xs"--}}
                                            {{--title="{{ trans('app.delete_title') }}"><i--}}
                                            {{--class="fa fa-trash"></i></button>--}}

                                            {{--{!! Form::close() !!}--}}

                                            {{--</li>--}}
                                            {{--@endif--}}

                                        @endif


                                        @if($loanRequests['request_status']=='0')
                                            <li>

                                                <a href="{{ route(ADMIN . '.loan_request.edit', $loanRequests['id']) }}"
                                                   title="{{ "Edit Loan Request" }}" class="btn btn-primary btn-xs"><i
                                                            class="fa fa-pencil"></i></a>
                                            </li>

                                            {{--<li>--}}
                                            {{--{!! Form::open([--}}
                                            {{--'class'=>'delete',--}}
                                            {{--'url'  => route(ADMIN . '.loan_request.destroy', $loanRequests['id']),--}}
                                            {{--'method' => 'DELETE',--}}
                                            {{--])--}}
                                            {{--!!}--}}

                                            {{--<button class="btn btn-danger btn-xs"--}}
                                            {{--title="{{ trans('app.delete_title') }}"><i--}}
                                            {{--class="fa fa-trash"></i></button>--}}

                                            {{--{!! Form::close() !!}--}}

                                            {{--</li>--}}
                                        @endif
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

    <div class="modal fade" id="emiPendingModel" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <div id="loading">
                        <!-- You can add gif image here
                        for this demo we are just using text -->
                        <h4 style="color:darkgreen;">Sending...</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5><b>User Email:</b> &nbsp;&nbsp; <span id="user_email"></span></h5>
                    <h4 class="modal-title text-center">EMI Pending List</h4>
                     <input type="hidden" id="emi_request_id" value="">
                    <input type="hidden" id="emi_user_email" value="">

                    <button type="button" class="btn btn-default" id="send_pending_email">Send Emi Remainder Email</button>

                </div>
                <div class="modal-body">
                    <table id="emiPendingList" class="table"
                           width="100%">
                        <thead>
                        <tr>
                            <th>EMI AMOUNT(IN $)</th>
                            <th>EMI DATE</th>
                            <th>Penalty(in $)</th>
                            <th>Total EMI(in $)</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        (function ($) {
            var table = $('.data-tables').DataTable({
                "columnDefs": [{
                    "targets": 'no-sort',
                }],
                "order": []
            });
            //replace bool column to checkbox
            renderBoolColumn('#tbl', 'bool');
        })(jQuery);

        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(".emi-pending-click").click(function (e) {
                e.preventDefault();
                var requestId = $(this).attr('data-requestId');
                $('#emiPendingList').DataTable({
                    processing: true,
                    serverSide: true,
                    "bDestroy": true,
                    "ajax": {
                        url: '{{route(ADMIN.'.loan_request.emiPendingPostAjax')}}',
                        type: 'POST',
                        data: {'requestId': requestId},

                    },
                    columns: [
                        {data: 'emi_amount', name: 'emi_amount'},
                        {data: 'tenuar_date', name: 'tenuar_date'},
                        {data: 'penalty', name: 'penalty'},
                        {data: 'total_emi', name: 'total_emi'}
                    ],
                    "initComplete": function (settings, json) {
                        $("#user_email").html(json.data[0].email);
                        $("#emi_user_email").val(json.data[0].email);
                        $("#emi_request_id").val(json.data[0].request_id);
                    }
                });
            })
            $("#send_pending_email").click(function (e) {
                e.preventDefault();
                var request_id=$("#emi_request_id").val();
                var email=$("#emi_user_email").val();
                $.ajax({
                    url: '{{route(ADMIN.'.emiPendingEmail')}}',
                    data: {
                        requestId: request_id,
                        email: email,
                        "_token": "{{csrf_token()}}"
                    },
                    method: 'post',
                    dataType: 'json',
                    success: function (res) {
                        notification("Email Sent Successfully","success");
                    }
                });
            })
            $(document).ajaxStart(function() {
                $("#loading").show();
            }).ajaxStop(function() {
                $("#loading").hide();
            });
        });
    </script>
@stop
