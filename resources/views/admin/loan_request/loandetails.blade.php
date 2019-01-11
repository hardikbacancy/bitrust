@extends('admin.adminlayout')

@section('css')
@stop
@section('page-header')
    Loan Request
    <small>{{ trans('app.manage') }}</small>
@stop
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box" style="border:1px solid #d2d6de;">
                <form id="form-submit" method="POST">
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        @if (auth()->user()->hasRole('Superadmin|Admin'))
                            <table id="tbl" class="table data-tables table-striped table-hover display select"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Amount(Per Month)</th>
                                    <th>Interest Amount(Per Month)</th>
                                    <th>EMI Amount(Per Month)</th>
                                    <th>EMI Date</th>
                                    <th>EMI Status</th>
                                    <th>EMI Paid Date</th>
                                    <th>Penalty</th>
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
                                    <th></th>
                                    <th></th>

                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($userLoanMgmt as $userLoanMgmts)
                                    <tr>
                                        <td>{{$userLoanMgmts['id']}}></td>
                                        <td>{{floor($loanRequest[0]['loan_amount']/$loanRequest[0]['tenuar_period'])}}</td>
                                        <td>{{$userLoanMgmts['emi_amount']-floor($loanRequest[0]['loan_amount']/$loanRequest[0]['tenuar_period'])}}</td>
                                        <td>{{$userLoanMgmts['emi_amount']}}</td>
                                        <td>{{$userLoanMgmts['tenuar_date']}}</td>
                                        <td>
                                            <label class="switch">

                                                    <input type="checkbox" value="{{$userLoanMgmts['id']}}"
                                                           name="loan_switch_{{$userLoanMgmts['id']}}"
                                                           class="loan_switch_class"
                                                           @if($userLoanMgmts['tenuar_status']=='1') checked @endif>

                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td id="emi_paid_date_{{$userLoanMgmts['id']}}">{{$userLoanMgmts['emi_paid_date']}}</td>

                                            <td><input type="text" name="penalty_{{$userLoanMgmts['id']}}" id="penalty"
                                                       value="{{$userLoanMgmts['penalty']}}"></td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                                @else
                            <table id="tb2" class="table data-tables table-striped table-hover display select"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Amount(Per Month)</th>
                                    <th>Interest Amount(Per Month)</th>
                                    <th>EMI Amount(Per Month)</th>
                                    <th>EMI Date</th>
                                    <th>EMI Status</th>
                                    <th>EMI Paid Date</th>
                                    <th>Penalty</th>

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
                                    <th></th>

                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($userLoanMgmt as $userLoanMgmts)
                                    <tr>
                                        <td>{{floor($loanRequest[0]['loan_amount']/$loanRequest[0]['tenuar_period'])}}</td>
                                        <td>{{$userLoanMgmts['emi_amount']-floor($loanRequest[0]['loan_amount']/$loanRequest[0]['tenuar_period'])}}</td>
                                        <td>{{$userLoanMgmts['emi_amount']}}</td>
                                        <td>{{$userLoanMgmts['tenuar_date']}}</td>
                                        <td>

                                           @if($userLoanMgmts['tenuar_status']=='1') <p>Paid</p>
                                           @else
                                               <p>Unpaid</p>
                                            @endif

                                        </td>
                                        <td>{{$userLoanMgmts['emi_paid_date']}}</td>
                                        <td>{{$userLoanMgmts['penalty']}}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        @endif
                    </div>

                    <p>
                        @if (auth()->user()->hasRole('Superadmin|Admin'))
                           <button type="submit" class="update-btn">Update</button>
                        @endif


                    </p>
                </form>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop
@section('js')
    <script>
        var table;
        $(document).ready(function (e) {

             table = $('#tbl').DataTable({
                'columnDefs': [
                    {
                        'targets': 0,
                        'checkboxes': {
                            'selectRow': true
                        }
                    }
                ],
                'select': {
                    'style': 'multi'
                },
                'order': [[1, 'asc']]
            });

            var table_2 = $('#tb2').DataTable();

            $('#form-submit').on('submit', function (e) {
                e.preventDefault();
                var data = table.$('input').serializeArray();
                var rows_selected = table.column(0).checkboxes.selected();
                var check_select = [];
                $.each(rows_selected, function(index, rowId){
                    var stripped = rowId.replace(/[^0-9]/g, '');
                    check_select.push(stripped);
                });
                $.ajax({
                    url: '/admin/statusPenalty',
                    data: {dataValue: data,check_select:check_select,"_token": "{{csrf_token()}}"},
                    method: 'post',
                    dataType: 'json',
                    success: function (res) {
                        location.reload();
                    }
                });
            });

            $(document.body).on('change', '.loan_switch_class', function () {
                var val = $(this).is(":checked");
                if (val) {
                    var id = $(this).attr('value');
                    var check_val = 1;
                }
                else {
                    var id = $(this).attr('value');
                    var check_val = 0;
                }
                $.ajax({
                    url: '/admin/loan_request/loanStatusUpdate',
                    data: {'id': id, 'check_value': check_val, "_token": "{{csrf_token()}}"},
                    dataType: 'json',
                    type: 'post',
                    success: function (res) {
                     notification("Updated successfully.!", "success");
                      $("#emi_paid_date_"+res.id).html(res.emi_paid_date);
                     //    table.clear();
                     //    table.rows.add(res);
                     //    table.draw();
                    }
                });
            });


            renderBoolColumn('#tbl', 'bool');
            renderBoolColumn('#tb2', 'bool');
        })
    </script>
@stop
