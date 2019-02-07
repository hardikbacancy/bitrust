@extends('admin.adminlayout')
@section('page-header')
    Expense
    <small>Update</small>
@stop

@section('content')
    @if(session()->has('message'))
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {!! session('message') !!}
        </div>
    @endif
    <div class="row" id="expense-update">
        <div class="col-md-12">
            <div class="box" style="border:1px solid #d2d6de;">
                <form style="padding: 15px;" method="post" action="{{route(ADMIN.'.expense.update')}}" id="expense-update-form">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="id" value="{{$expensesDetails['id']}}">


                    <div class="form-group">
                        <label for="expense">Expense</label>
                        <input type="text" class="form-control number_class" placeholder="Expense Amount"
                               id="expense_amount" name="expense_amount" value="{{$expensesDetails['expense']}}">
                    </div>

                    <div>
                        <button type="submit" value="Submit" class="btn btn-primary" style="width:100px;">Update</button>
                        <a class="btn btn-warning" href="{{ URL::previous() }}" style="width:100px;"><i
                                    class="fa fa-btn fa-back"></i>Cancel</a>

                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $(document).ready(function (e) {

            $('#expense-update-form').validate({ // initialize the plugin
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