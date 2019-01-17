@extends('admin.adminlayout')

@section('css')
  <style>
  table.table .actions {
      width: 100px;
      text-align: center;
  }
  </style>
@stop

@section('page-header')
    Admin Setting <small>{{ trans('app.manage') }}</small>
@stop

@section('content')

	<div class="row">
	  <div class="col-xs-12">
	    <div class="box" style="border:1px solid #d2d6de;" >

	      {{--<div class="box-header" style="background-color:#f5f5f5;border-bottom:1px solid #d2d6de;">--}}
	      {{--</div>--}}

	      <!-- /.box-header -->
	      <div class="box-body table-responsive no-padding"  >
	        <table id="tbl" class="table data-tables table-striped table-hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Penalty(in $)</th>
                    <th>Interest Rate(in %)</th>
                    <th>Membership Fee(in $)</th>
                    <th>Updated At</th>
                    <th class="no-sort"></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th class="actions"></th>
                </tr>
            </tfoot>
            <tbody>

      					@foreach ($items as $item)
      						<tr>
                      <td><a href="{{ route(ADMIN . '.adminsettings.edit', $item->id) }}">{{ $item->penalty }}</a></td>
                      
                      <td>
                          {{ $item->interest_rate }}
                      </td> 
                      <td>
                          {{ $item->membership_fee }}
                      </td> 
                       <td>
                          {{ $item->updated_at }}                      
                      </td>
                      <td class="actions">
                            <ul class="list-inline" style="margin-bottom:0px;">
                                <li><a href="{{ route(ADMIN . '.adminsettings.edit', $item->id) }}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a></li>
                               
                            </ul>
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
<!--   <script>

    (function($) {

      var table = $('.data-tables').DataTable({
          "columnDefs": [{
                 "targets": 'no-sort',
                 "orderable": false,
           }],
      });

    })(jQuery);
  </script> -->
@stop
