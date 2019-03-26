@extends('admin.adminlayout')

@section('page-header')
    Dashboard <small>Home</small>
@stop

@section('content')
    <div class="row" >
        <div class="col-md-12">
            <div class="panel panel-default"  >
                <div class="panel-body" >
                    Welcome {{ Auth::user()->name }} !!!
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->hasRole('Superadmin|Admin'))
    <div class="row">
        <div class="col-md-4">
            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Fund&nbsp;(in $)</span>
                    <span class="info-box-number">{{$totalMembershipFees+$profit}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="font-size: 13px;">Total Available Balance&nbsp;(in $)</span>
                    <span class="info-box-number">{{$totalMembershipFees+$profit-$loanAmount-$expense}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <a href="{{route(ADMIN.'.loan_request.index')}}">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Loan Amount&nbsp;(in $)</span>
                    <span class="info-box-number">{{$loanAmount}}</span>
                </div>
            </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <a href="{{route(ADMIN.'.loanProfit')}}">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Loan Profit&nbsp;(in $)</span>
                    <span class="info-box-number">{{$profit}}</span>
                </div>
            </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{route(ADMIN.'.expense')}}">
            <div class="info-box bg-orange">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Expense&nbsp;(in $)</span>
                    <span class="info-box-number">{{$expense}}</span>
                </div>
            </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{route(ADMIN.'.users.index')}}">
            <div class="info-box bg-gray">
                <span class="info-box-icon"><i class="fa fa-user-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total User Count</span>
                    <span class="info-box-number">{{$userCount}}</span>
                </div>
            </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            
            <div class="info-box bg-secondary">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Interest&nbsp;(in $)</span>
                    <span class="info-box-number">{{$totalInterest}}</span>
                </div>
            </div>
           
        </div>
        <div class="col-md-4">
           
            <div class="info-box bg-light">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Penalty&nbsp;(in $)</span>
                    <span class="info-box-number">{{$totalPenalty}}</span>
                </div>
            </div>
           
        </div>
    </div>

    @else
        <div class="row">
            <div class="col-md-4">
                <div class="info-box bg-red">
                    <span class="info-box-icon"><i class="fa fa-money"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Membership&nbsp;(in $)</span>
                        <span class="info-box-number">{{$totalMembershipFees}}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-box bg-gray">
                    <span class="info-box-icon"><i class="fa fa-money"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Loan Amount&nbsp;(in $)</span>
                        <span class="info-box-number">{{$loanAmount}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-blue">
                    <span class="info-box-icon"><i class="fa fa-money"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">EMI Paid Amount&nbsp;(in $)</span>
                        <span class="info-box-number">{{$paidAmount}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-money"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text" style="font-size: 13px;">EMI Remainning Amount&nbsp;(in $)</span>
                        <span class="info-box-number">{{$unpaidAmount}}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop
