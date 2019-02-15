@extends('admin.adminlayout')
@section('page-header')
    Expense
    <small>New</small>
@stop

@section('content')
    @if(session()->has('message'))
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {!! session('message') !!}
        </div>
    @endif

    <div class="row" id="expense-create">
        <div class="col-md-12">
            <div class="box" style="border:1px solid #d2d6de;">
                <form style="padding: 15px;" method="post" action="{{route(ADMIN.'.expense.store')}}" id="expense-create-form">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                    <div class="form-group">
                        <label for="year">Expense Type <a style="margin-left: 10px;
    margin-bottom: 7px;" class="btn btn-info" href="" title="Add Expense Type"  data-toggle="modal" data-target="#expenseModal">
                                <i class="fa fa-plus" style="vertical-align:middle;"></i> Add More Expense Type
                            </a></label>
                        <select class="form-control" id="expense_id" name="expense_id">
                            @foreach($expenses as $expense)
                                <option value={{$expense['id']}}>{{$expense['expense_type']}}</option>;
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="year">Select Year:</label>
                        <select class="form-control" id="year" name="year">
                            <?php
                            for($i = date('Y');$i >= 2000;$i--)
                            {  ?>
                            <option value="{{$i}}">{{$i}}</option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="month">Select Month:</label>
                        <select class="form-control" id="month" name="month">
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="year">Expense</label>
                        <input type="text" class="form-control number_class" placeholder="Expense Amount"
                               id="expense_amount" name="expense_amount">
                    </div>

                    <div>
                        <button type="submit" value="Submit" class="btn btn-primary" style="width:100px;">Save</button>
                        <a class="btn btn-warning" href="{{ URL::previous() }}" style="width:100px;"><i
                                    class="fa fa-btn fa-back"></i>Cancel</a>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="expenseModal" class="modal fade" role="dialog">
        <div class="modal-dialog custom-model">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">Add Expense Type</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="usr">Expense Type Name</label>
                        <input style="margin-top:6px;" type="text" class="form-control" name="add_expense_type" id="add_expense_type" value="" placeholder="Add Expense Type">
                    </div>
                    <div class="form-group text-right" style="margin-bottom: 0">
                    <button type="button" id="expense_type_button" class="btn btn-primary">Save</button>

                </div>  </div>
            </div>

        </div>
    </div>
@stop
@section('js')
    <script>
        $(document).ready(function (e) {
            $("#expense_id").select2();
            $("#year").select2();
            $("#month").select2();
            $('#expense-create-form').validate({ // initialize the plugin
                rules: {
                    expense_amount: {
                        required: true
                    },
                }
            });
            $("body").on('keypress', '.number_class', function (event) {
                if (isNumberWithDot(event, this)) {
                    return true;
                }
                else {
                    return false;
                }
            });

            $("#expense_type_button").click(function(e){
                e.preventDefault();
                if($("#add_expense_type").val()==""){
                    notification("Please enter expense type","success");
                }else{
                    var expense_type=$("#add_expense_type").val();
                    $.ajax({
                        url: '{{route(ADMIN.'.expense.addExpenseType')}}',
                        data: {
                            expense_type: expense_type,
                            "_token": "{{csrf_token()}}"
                        },
                        method: 'post',
                        dataType: 'json',
                        success: function (res) {
                            var div_data = "";
                            $.each(res, function (i, obj) {
                                div_data += "<option value=" + obj.id + ">" + obj.expense_type + "</option>";
                            });
                            $("#expense_id").html(div_data);
                            $('#expenseModal').modal('hide');
                            $('#add_expense_type').val(" ");
                            notification("Added Successfully","success");
                        }
                    });
                }
            });

            function isNumberWithDot(evt, element) {
                var charCode = (evt.which) ? evt.which : event.keyCode;
                if (charCode == 8) {
                    return true;
                }
                if (
                    (charCode != 46 || $(element).val().indexOf('.') != -1) && // “.” CHECK DOT, AND ONLY ONE.
                    (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
        })
    </script>
@stop