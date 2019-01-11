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
                    <span class="info-box-text">Total Fund</span>
                    <span class="info-box-number">{{$adminSettings[0]['membership_fee']*$userCount}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Available Balance</span>
                    <span class="info-box-number">{{$adminSettings[0]['membership_fee']*$userCount-$loanAmount}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Loan Amount</span>
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
                    <span class="info-box-text">Expected Total Profit</span>
                    <span class="info-box-number">{{$loanAmount*$adminSettings[0]['interest_rate']/100}}</span>
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
    @endif

@stop
