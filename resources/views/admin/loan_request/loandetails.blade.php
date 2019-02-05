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
                    <p style="margin-top:10px;">
                        @if (auth()->user()->hasRole('Superadmin|Admin'))
                            <select id="paid_status" name="paid_status" class="paid_status_drop">
                                <option value="1">Paid</option>
                                <option value="0">Unpaid</option>
                            </select>
                            <button type="submit" id="update_bulk" class="update-btn" disabled>Update</button>
                        @endif
                    </p>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        @if (auth()->user()->hasRole('Superadmin|Admin'))
                            <input type="hidden" name="requestId" id="requestId" value="{{$loanRequest[0]['id']}}">

                            <table id="tbl" class="table data-tables table-striped table-hover display select"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th class="checkbox_selection"></th>
                                    <th>Amount(Per Month in $)</th>
                                    <th>Interest Amount(Per Month in $)</th>
                                    <th>EMI Amount(Per Month in $)</th>
                                    <th>EMI Date</th>
                                    <th>Penalty(in $)</th>
                                    <th>EMI Status</th>
                                    <th>EMI Paid Date</th>

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
                                        <td class="checkbox_selection">{{$userLoanMgmts['id']}}</td>
                                        <td>{{floor($loanRequest[0]['loan_amount']/$loanRequest[0]['tenuar_period'])}}</td>
                                        <td>{{$userLoanMgmts['emi_amount']-floor($loanRequest[0]['loan_amount']/$loanRequest[0]['tenuar_period'])}}</td>
                                        <td>{{$userLoanMgmts['emi_amount']}}</td>
                                        <td style="width:10%;">{{$userLoanMgmts['tenuar_date']}}</td>
                                        <td><input type="text" name="penalty" id="penalty_{{$userLoanMgmts['id']}}"
                                                   value="{{$userLoanMgmts['penalty']}}" class="number_class"></td>
                                        <td>
                                            <label class="switch">

                                                    <input type="checkbox" value="{{$userLoanMgmts['id']}}"
                                                           name="loan_switch_{{$userLoanMgmts['id']}}"
                                                           class="loan_switch_class"
                                                           @if($userLoanMgmts['tenuar_status']=='1') checked @endif>

                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td style="width:10%;" id="emi_paid_date_{{$userLoanMgmts['id']}}">@if(isset($userLoanMgmts['emi_paid_date'])){{$userLoanMgmts['emi_paid_date']}} @else {{"-"}}@endif</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                                @else
                            <table id="tb2" class="table data-tables table-striped table-hover display select"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Amount(Per Month in $)</th>
                                    <th>Interest Amount(Per Month in $)</th>
                                    <th>EMI Amount(Per Month in $)</th>
                                    <th>EMI Date</th>
                                    <th>Penalty(in $)</th>
                                    <th>EMI Status</th>
                                    <th>EMI Paid Date</th>
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
                                        <td style="width:10%;">{{$userLoanMgmts['tenuar_date']}}</td>
                                        <td>@if(isset($userLoanMgmts['penalty'])){{$userLoanMgmts['penalty']}} @else {{"-"}}@endif</td>
                                        <td>

                                           @if($userLoanMgmts['tenuar_status']=='1') <p>Paid</p>
                                           @else
                                               <p>Unpaid</p>
                                            @endif

                                        </td>
                                        <td style="width:10%;">@if(isset($userLoanMgmts['emi_paid_date'])){{$userLoanMgmts['emi_paid_date']}}@else {{"-"}} @endif</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        @endif
                    </div>

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
                //var data = table.$('input').serializeArray();

                var paid_status_val=$("#paid_status").val();
                var rows_selected = table.column(0).checkboxes.selected();
                var requestId=$("#requestId").val();
                var check_select = [];
                $.each(rows_selected, function(index, rowId){
                    var stripped = rowId.replace(/[^0-9]/g, '');
                    var penalty = table.$('#penalty_'+stripped).val();
                    check_select.push(stripped+"_"+penalty);
                });

                if(check_select.length>0) {
                    $.ajax({
                        url: '{{route(ADMIN.'.statusPenalty')}}',
                        data: {
                            check_select: check_select,
                            requestId: requestId,
                            paid_status:paid_status_val,
                            "_token": "{{csrf_token()}}"
                        },
                        method: 'post',
                        dataType: 'json',
                        success: function (res) {
                            location.reload();
                        }
                    });
                }
                else{
                    alert("please select at least one checkbox");
                }
            });
            $(document.body).on('change', '.loan_switch_class', function () {
                var val = $(this).is(":checked");
                if (val) {
                    var id = $(this).attr('value');
                    var penalty=$("#penalty_"+id).val();
                    var check_val = 1;
                }
                else {
                    var id = $(this).attr('value');
                    var check_val = 0;
                    var penalty=$("#penalty_"+id).val();
                }

                $.ajax({
                    url: '{{route(ADMIN.'.loanStatusUpdate')}}',
                    data: {'id': id, 'check_value': check_val,'penalty':penalty,"_token": "{{csrf_token()}}"},
                    dataType: 'json',
                    type: 'post',
                    success: function (res) {
                        if(res.emi_paid_date) {
                            $("#emi_paid_date_" + res.id).html(res.emi_paid_date);
                        }
                        else{
                            $("#emi_paid_date_" + res.id).html("-");

                        }
                    }
                });
            });
            renderBoolColumn('#tbl', 'bool');
            renderBoolColumn('#tb2', 'bool');

            $(document.body).on('change', '.checkbox_selection', function(e) {
                var rows_selected = table.column(0).checkboxes.selected();
                var check_select = [];
                $.each(rows_selected, function(index, rowId){
                    var stripped = rowId.replace(/[^0-9]/g, '');
                    check_select.push(stripped);
                });

                if(check_select.length>0){
                    $('#update_bulk').attr('disabled' , false);
                }
                else{
                    $('#update_bulk').attr('disabled' , true);
                }
            });

            $("body").on('keypress', '.number_class', function (event) {
                if(isNumberWithDot(event, this)){
                    return true;
                }
                else{
                    return false;
                }
            });

            function isNumberWithDot(evt, element) {

                var charCode = (evt.which) ? evt.which : event.keyCode;

                if (charCode == 8){
                    return true;
                }
                if (
                    (charCode != 46 || $(element).val().indexOf('.') != -1) && // “.” CHECK DOT, AND ONLY ONE.
                    (charCode < 48 || charCode > 57)){
                    return false;
                }

                return true;
            }
        })

    </script>
@stop
