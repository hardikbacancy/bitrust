@extends('admin.adminlayout')

@section('page-header')
    Import
    <small>Import</small>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content')
    <div class="container" style="width:100%;">

        <div class="row">
            <div class="col-md-12">
                @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        {{Session::get('message')}}
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" style="padding: 0">
                <form class="form-import-main" action="{{route(ADMIN.'.membership.importMembership')}}" method="post" enctype="multipart/form-data">
                       {{ csrf_field() }}
                    <input type="file" name="import_file"/><br>
                    <button class="btn btn-primary">Import File</button>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')

@stop