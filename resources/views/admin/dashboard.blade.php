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
                    <span class="info-box-text">Total Fund(in $)</span>
                    <span class="info-box-number">{{$totalMembershipFees+$profit}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text" style="font-size: 13px;">Total Available Balance(in $)</span>
                    <span class="info-box-number">{{$totalMembershipFees+$profit-$loanAmount}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Loan Amount(in $)</span>
                    <span class="info-box-number">{{$loanAmount}}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Loan Profit(in $)</span>
                    <span class="info-box-number">{{$profit}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-gray">
                <span class="info-box-icon"><i class="fa fa-user-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total User Count</span>
                    <span class="info-box-number">{{$userCount}}</span>
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
                        <span class="info-box-text">Total Loan Amount(in $)</span>
                        <span class="info-box-number">{{$loanAmount}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-blue">
                    <span class="info-box-icon"><i class="fa fa-money"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">EMI Paid Amount(in $)</span>
                        <span class="info-box-number">{{$paidAmount}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-money"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text" style="font-size: 13px;">EMI Remainning Amount(in $)</span>
                        <span class="info-box-number">{{$unpaidAmount}}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop
