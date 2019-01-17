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
    Loan Request
    <small>{{ trans('app.manage') }}</small>
@stop
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box" style="border:1px solid #d2d6de;">
                <div class="box-header" style="background-color:#f5f5f5;border-bottom:1px solid #d2d6de;">
                    <a class="btn btn-info" href="{{ route(ADMIN . '.loan_request.create') }}" title="Add Item">
                        <i class="fa fa-plus" style="vertical-align:middle"></i>
                    </a>
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
                                <td>{{$loanRequests['loan_amount']*$loanRequests['interest_rate']/100+$loanRequests['loan_amount']}}</td>
                                <td>{{$loanRequests['paidEmiAmount']}}</td>
                                <td>{{$loanRequests['remainningEmiAmount']}}</td>
                                <td>{{$loanRequests['completed']}}</td>
                                <td>{{$loanRequests['request_status']}}</td>
                                <td class="actions">
                                        <ul class="list-inline" style="margin-bottom:0px;">

                                           @if($loanRequests['request_status']=='1')
                                            <li>
                                                <a href="{{route(ADMIN . '.loan_request.loan_details', $loanRequests['id'])}}"
                                                   title="{{ "View Details" }}" class="btn btn-primary btn-xs"><i
                                                            class="fa fa-eye"></i>
                                                </a>
                                            </li>

                                                    @if (auth()->user()->hasRole('Superadmin|Admin'))
                                                <li>
                                                    {!! Form::open([
                                                        'class'=>'delete',
                                                        'url'  => route(ADMIN . '.loan_request.destroy', $loanRequests['id']),
                                                        'method' => 'DELETE',
                                                        ])
                                                    !!}

                                                    <button class="btn btn-danger btn-xs"
                                                            title="{{ trans('app.delete_title') }}"><i
                                                                class="fa fa-trash"></i></button>

                                                    {!! Form::close() !!}

                                                </li>
                                                    @endif

                                            @endif


                                            @if($loanRequests['request_status']=='0')
                                            <li>

                                                <a href="{{ route(ADMIN . '.loan_request.edit', $loanRequests['id']) }}"
                                                   title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-xs"><i
                                                            class="fa fa-pencil"></i></a>
                                            </li>

                                                    <li>
                                                        {!! Form::open([
                                                            'class'=>'delete',
                                                            'url'  => route(ADMIN . '.loan_request.destroy', $loanRequests['id']),
                                                            'method' => 'DELETE',
                                                            ])
                                                        !!}

                                                        <button class="btn btn-danger btn-xs"
                                                                title="{{ trans('app.delete_title') }}"><i
                                                                    class="fa fa-trash"></i></button>

                                                        {!! Form::close() !!}

                                                    </li>
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
@stop
@section('js')
    <script>
        (function ($) {
            var table = $('.data-tables').DataTable({
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                }],
            });
            //replace bool column to checkbox
            renderBoolColumn('#tbl', 'bool');
        })(jQuery);
    </script>
@stop
