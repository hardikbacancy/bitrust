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
    Non-Loan Users
    <small>{{ trans('app.manage') }}</small>
@stop

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <div class="box" style="border:1px solid #d2d6de;">
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table id="tbl" class="table data-tables table-striped table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Member From</th>
                            <th>Membership Fee</th>
                            {{--<th>Interest</th>--}}
                            {{--<th>Profit</th>--}}
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>

                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user['name'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['created_at'] }}</td>
                                <td>{{ $adminSettings[0]['membership_fee'] }}</td>
                                {{--<td>{{ $adminSettings[0]['interest_rate']}}</td>--}}
                                {{--<td>{{  ceil($adminSettings[0]['membership_fee']*$adminSettings[0]['interest_rate']/100) }}</td>--}}
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
