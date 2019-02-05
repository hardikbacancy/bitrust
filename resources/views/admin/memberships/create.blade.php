@extends('admin.adminlayout')
@section('page-header')
  Membership <small>New</small>
@stop

@section('content')
  @if(session()->has('message'))
    <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert">×</button>
      {!! session('message') !!}
    </div>
  @endif
<div class="row" id="member-create">
  <div class="col-md-12">
    <div class="box" style="border:1px solid #d2d6de;">
      <form style="padding: 15px;" method="post" action="{{route(ADMIN.'.membership.store')}}">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="user_id" value="{{$userDetails->id}}">

        <div class="row">
          <div class="col-md-2">
        <label for="user_id">User Email:</label>
          </div>
          <div class="col-md-6">
        <span> {{$userDetails->email}}</span>
          </div>
        </div>
        <br>
      <div class="form-group mb30">
        <label for="year">Select Year:</label>
        <select class="form-control" id="year" name="year">

                     @foreach($year_output as $year_output)
                     <option value={{$year_output}}>{{$year_output}}</option>;
                     @endforeach
        </select>
      </div>

        <div class="row mb30">
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
          <input type="text" class="form-control number_class" placeholder="January Fee" id="jan_fees" name="jan_fees">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class" placeholder="January Penalty" id="jan_penalty" name="jan_penalty">
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">
          <label for="jan">February</label>
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class" placeholder="February Fee" id="feb_fees" name="feb_fees">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class" placeholder="February Penalty" id="feb_penalty" name="feb_penalty">
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">
          <label for="jan">March</label>
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class" placeholder="March Fee" id="march_fees" name="march_fees">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class" placeholder="March Penalty" id="march_fees" name="march_penalty">
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">
          <label for="jan">April</label>
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class" placeholder="April Fee" id="april_fees" name="april_fees">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class" placeholder="April Penalty" id="april_penalty" name="april_penalty">
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">
          <label for="jan">May</label>
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class" Placeholder="May Fees" id="may_fees" name="may_fees">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class" Placeholder="May Penalty" id="may_penalty" name="may_penalty">
        </div>
      </div>


      <div class="row">
        <div class="col-md-2">
          <label for="jan">June</label>
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class" placeholder="June Fees" id="june_fees" name="june_fees">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class"  placeholder="June Penalty" id="june_penalty" name="june_penalty">
        </div>
      </div>


      <div class="row">
        <div class="col-md-2">
          <label for="jan">July</label>
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class" placeholder="July Fees" id="july_fees" name="july_fees">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class"  placeholder="July Penalty" id="july_penalty" name="july_penalty">
        </div>
      </div>


      <div class="row">
        <div class="col-md-2">
          <label for="jan">August</label>
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class" placeholder="August Fees" id="aug_fees" name="aug_fees">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class"  placeholder="August Penalty" id="aug_penalty" name="aug_penalty">
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">
          <label for="jan">September</label>
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class" placeholder="September Fees" id="sep_fees" name="sep_fees">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class"  placeholder="September Penalty" id="sep_penalty" name="sep_penalty">
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">
          <label for="jan">October</label>
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class" placeholder="October Fees" id="oct_fees" name="oct_fees">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class"  placeholder="October Penalty" id="oct_penalty" name="oct_penalty">
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">
          <label for="jan">November</label>
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class" placeholder="November Fees" id="nov_fees" name="nov_fees">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class"  placeholder="November Penalty" id="nov_penalty" name="nov_penalty">
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">
          <label for="jan">December</label>
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class" placeholder="December Fees" id="dec_fees" name="dec_fees">
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control number_class"  placeholder="December Penalty" id="dec_penalty" name="dec_penalty">
        </div>
      </div>
        <br>
      <div>
        <button type="submit" value="Submit" class="btn btn-primary" style="width:100px;">Create</button>
        <a class="btn btn-warning" href="{{ URL::previous() }}" style="width:100px;"><i class="fa fa-btn fa-back"></i>Cancel</a>

      </div>
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