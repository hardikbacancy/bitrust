@extends('admin.adminlayout')
@section('css')
    <style>
        table.table .actions {
            width: 100px;
            text-align: center;
        }
        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
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
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table id="tbl" class="table data-tables table-striped table-hover" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>EMI Amount</th>
                            <th>Tenuar Date</th>
                            <th>Tenuar Status</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach($userLoanMgmt as $userLoanMgmts)
                            <tr>
                                <td>{{$userLoanMgmts['emi_amount']}}</td>
                                <td>{{$userLoanMgmts['tenuar_date']}}</td>
                                <td>
                                    <label class="switch">
                                        @if(\Auth::user()->role!='0')
                                        <input type="checkbox" value="{{$userLoanMgmts['id']}}" name="loan_switch" class="loan_switch_class" @if($userLoanMgmts['tenuar_status']=='1') checked @endif>
                                        @else
                                            <input type="checkbox" value="{{$userLoanMgmts['id']}}" name="loan_switch" class="loan_switch_class" @if($userLoanMgmts['tenuar_status']=='1') checked @endif disabled>
                                        @endif
                                        <span class="slider round"></span>
                                    </label>
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

        $(document).ready(function(){
            $(document.body).on('change', '.loan_switch_class', function () {
                var val = $(this).is(":checked");
                if(val){
                    var id = $(this).attr('value');
                    var check_val=1;

                }
                else{
                    var id = $(this).attr('value');
                    var check_val=0;
                }
                $.ajax({
                    url: '/admin/loan_request/loanStatusUpdate',
                    data: {'id': id, 'check_value':check_val,"_token": "{{csrf_token()}}" },
                    dataType: 'json',
                    type:'post',
                    success: function (res) {

                    }
                });

            });
        })
    </script>
@stop
