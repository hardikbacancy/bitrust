@extends('admin.adminlayout')
@section('page-header')
    Membership
    <small>View</small>
@stop

@section('content')
    @if(session()->has('message'))
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {!! session('message') !!}
        </div>
    @endif

    <div class="box-header" style="background-color:#f5f5f5;border-bottom:1px solid #d2d6de;">
        <div class="row">
            <div class="col-md-2">
                <label>User Email:</label>
            </div>
            <div class="col-md-4">
                @foreach($userDetails as $userDetail)
                    @if($userDetail['id']==$membershipData['user_id'])
                        <span>{{$userDetail['email']}}</span>
                    @endif
                @endforeach
            </div>
            <div class="col-md-2">
                <label>Year</label> :
            </div>
            <div class="col-md-4">
                <span>{{$membershipData['year']}}</span>
            </div>
        </div>
    </div>


    <div class="row" id="member-view">
        <div class="col-md-12">
            <div class="box" style="border:1px solid #d2d6de;margin-top:0px !important;">
                <form style="padding: 15px;">
                    <div class="row">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-4">
                            <label for="fees">Fees(in $)</label>
                        </div>
                        <div class="col-md-4">
                            <label for="penalty">Penalty(in $)</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <label for="jan">January</label>
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['jan_fees']}}
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['jan_penalty']}}
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-2">
                            <label for="jan">February</label>
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['feb_fees']}}
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['feb_penalty']}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="jan">March</label>
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['march_fees']}}
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['march_penalty']}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="jan">April</label>
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['april_fees']}}
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['april_penalty']}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="jan">May</label>
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['may_fees']}}
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['may_penalty']}}
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-2">
                            <label for="jan">June</label>
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['june_fees']}}
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['june_penalty']}}
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-2">
                            <label for="jan">July</label>
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['july_fees']}}
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['july_penalty']}}
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-2">
                            <label for="jan">August</label>
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['aug_fees']}}
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['aug_penalty']}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="jan">September</label>
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['sep_fees']}}
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['sep_penalty']}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="jan">October</label>
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['oct_fees']}}
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['oct_penalty']}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="jan">November</label>
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['nov_fees']}}
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['nov_penalty']}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="jan">December</label>
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['dec_fees']}}
                        </div>
                        <div class="col-md-4">
                            {{$membershipData['dec_penalty']}}
                        </div>
                    </div>
                    <br>
                    <a class="btn btn-warning "
                       href="{{ route(ADMIN.'.membership.membership_details',$membershipData['user_id']) }}"
                       style="width:100px;"><i class="fa fa-btn fa-back"></i>Cancel</a>
                </form>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $(document).ready(function (e) {
            $("#user_id").select2();
            $("#year").select2();
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