@extends('layouts.admin')
@section('title')
شاشة صرف النقدية
@endsection
@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('contentheader')
الحسابات
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.collect_transaction.index') }}"> شاشه صرف النقدية </a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title card_title_center">  بيانات حركة صرف النقدية بالنظام</h3>
      <input type="hidden" id="token_search" value="{{csrf_token() }}">
      <input type="hidden" id="ajax_url_get_account_blance" value="{{route('admin.exchange_transaction.get_account_blance')}}">
      <input type="hidden" id="ajax_url_ajax_search" value="{{route('admin.exchange_transaction.ajax_search')}}">
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      @if(!@empty($checkExistsOpenShift))
      <form action="{{ route('admin.exchange_transaction.store') }}" method="post"  class="custom_form">
         <div class="row">
            @csrf
            <div class="col-md-4 > 
               <div class="form-group">
               <label>تاريخ الحركة </label>
               <input type="date" name="move_date" id="move_date" class="form-control"  value="{{ old('move_date',date("Y-m-d")) }}"  >
               @error('move_date')
               <span class="text-danger">{{ $message }}</span>
               @enderror
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>   الحسابات المالية</label>
                  <select name="account_number" id="account_number" class="form-control select2 ">
                     <option value="">اختر الحساب المالي المصروف له</option>
                     @if (@isset($accounts) && !@empty($accounts))
                     @foreach ($accounts as $info )
                     <option data-type="{{ $info->account_type }}"   @if(old('account_number')==$info->account_number) selected="selected" @endif value="{{ $info->account_number }}"> {{ $info->name }} ({{ $info->account_type_name }}) </option>
                     @endforeach
                     @endif
                  </select>
                  @error('account_number')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-4" id="get_account_blancesDiv" style="display: none;" > 
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>    نوع الحركة</label>
                  <select name="mov_type" id="mov_type" class="form-control  ">
                     <option value="">اختر نوع الحركة</option>
                     @if (@isset($mov_type) && !@empty($mov_type))
                     @foreach ($mov_type as $info )
                     <option @if(old('mov_type')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('mov_type')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-4" id="AccountStatusDiv" style="display: none;" > 
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>   بيانات الخزن</label>
                  <select name="treasuries_id" id="treasuries_id" class="form-control ">
                     <option value="{{ $checkExistsOpenShift['treasuries_id'] }}"> {{ $checkExistsOpenShift['treasuries_name'] }} </option>
                  </select>
                  @error('treasuries_id')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-4 > 
               <div class="form-group">
               <label>  الرصيد المتاح بالخزنة   </label>
               <input  readonly name="treasuries_balance" id="treasuries_balance" class="form-control"  value="{{ $checkExistsOpenShift['treasuries_balance_now']*1 }}"  >
               @error('treasuries_balance')
               <span class="text-danger">{{ $message }}</span>
               @enderror
            </div>
            <div class="col-md-4 > 
               <div class="form-group">
               <label>قيمة المبلغ المصروف   </label>
               <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="money" id="money" class="form-control"  value="{{ old('money') }}"  >
               @error('money')
               <span class="text-danger">{{ $message }}</span>
               @enderror
            </div>
            <div class="col-md-8">
               <div class="form-group">
                  <label>   البيان</label>
                  <textarea name="byan" id="byan" class="form-control" rows="4" cols="10"> {{ old("byan","صرف نظير ") }} </textarea>
                  @error('byan')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group text-center">
                  <button id="do_exchange_now_btn" type="submit" class="btn btn-success btn-sm"> صرف الان</button>
               </div>
            </div>
         </div>
   </div>
   </form>  
   @else          
   <div class="alert alert-warning" style="color:brown !important">
      تنبيه لايوجد شفت مفتوح لك لكي تتمكن من الصرف
   </div>
   @endif
   <div class="clearfix"></div>
   <div class="row" style="padding: 15px;">
      <div class="col-md-4">
         <input checked type="radio" name="searchbyradio" id="searchbyradio" value="auto_serial"> بالكود 
         <input  type="radio" name="searchbyradio" id="searchbyradio" value="isal_number"> الايصال    
         <input  type="radio" name="searchbyradio" id="searchbyradio" value="account_number"> رقم الحساب   
         <input  type="radio" name="searchbyradio" id="searchbyradio" value="shift_code">  شفت   
         <input style="margin-top: 6px !important;" type="text" id="search_by_text" placeholder="" class="form-control"> <br>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label>  بحث  بالحسابات المالية</label>
            <select name="account_number_search" id="account_number_search" class="form-control select2 ">
               <option value="all"> بحث بالكل</option>
               @if (@isset($accounts) && !@empty($accounts))
               @foreach ($accounts as $info )
               <option data-type="{{ $info->account_type }}"    @if(old('account_number')==$info->account_number) selected="selected" @endif value="{{ $info->account_number }}"> {{ $info->name }}  ({{ $info->account_type_name }}) {{ $info->account_number }} </option>
               @endforeach
               @endif
            </select>
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label>  بحث  بالحركات المالية</label>
            <select name="mov_type_search" id="mov_type_search" class="form-control  ">
               <option value="all">  بحث بالكل</option>
               @if (@isset($mov_type) && !@empty($mov_type))
               @foreach ($mov_type as $info )
               <option @if(old('mov_type')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
               @endforeach
               @endif
            </select>
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label>  بحث   بالخزن</label>
            <select name="treasuries_search" id="treasuries_search" class="form-control select2">
               <option value="all">بحث بكل الخزن</option>
               @if (@isset($treasuries) && !@empty($treasuries))
               @foreach ($treasuries as $info )
               <option value="{{ $info->id }}"> {{ $info->name }} </option>
               @endforeach
               @endif
            </select>
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label>  بحث   بالمستخدمين</label>
            <select name="admins_search" id="admins_search" class="form-control select2">
               <option value="all">بحث بكل الخزن</option>
               @if (@isset($admins) && !@empty($admins))
               @foreach ($admins as $info )
               <option value="{{ $info->id }}"> {{ $info->name }} </option>
               @endforeach
               @endif
            </select>
         </div>
      </div>
      <div class="col-md-4"> </div>
      <div class="clearfix"></div>
      <div class="col-md-4">
         <div class="form-group">
            <label>      من تاريخ حركة</label>
            <input name="from_date_search" id="from_date_search" class="form-control" type="date" value=""    >
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label>     الي تاريخ حركة </label>
            <input name="to_date_search" id="to_date_search" class="form-control" type="date" value=""    >
         </div>
      </div>
      <div class="clearfix"></div>
   </div>
   <div id="ajax_responce_serarchDiv">
      @if (@isset($data) && !@empty($data) && count($data)>0)
      <table id="example2" class="table table-bordered table-hover">
         <thead class="custom_thead">
            <th>كود الي</th>
            <th> رقم الايصال</th>
            <th> الخزنة</th>
            <th>  المبلغ</th>
            <th>  الحركة</th>
            <th>  الحساب المالي</th>
            <th>  البيان</th>
            <th> المستخدم</th>
            <th></th>
         </thead>
         <tbody>
            @foreach ($data as $info )
            <tr>
               <td>{{ $info->auto_serial }}</td>
               <td>{{ $info->isal_number }}</td>
               <td>{{ $info->treasuries_name }}
                  <br>
                  شفت ({{ $info->shift_code }})
               </td>
               <td>{{ $info->money*(1)*(-1) }}</td>
               <td>{{ $info->mov_type_name }}</td>
               <td>{{ $info->account_name }} <br>
                  ({{ $info->account_type_name }})
               </td>
               <td>{{ $info->byan }}</td>
               <td > 
                  @php
                  $dt=new DateTime($info->created_at);
                  $date=$dt->format("Y-m-d");
                  $time=$dt->format("h:i");
                  $newDateTime=date("A",strtotime($time));
                  $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
                  @endphp
                  {{ $date }} <br>
                  {{ $time }}
                  {{ $newDateTimeType }}  <br>
                  بواسطة 
                  {{ $info->added_by_admin}}
               </td>
               <td>
                  <a href="{{ route('admin.treasuries.edit',$info->id) }}" class="btn btn-sm  btn-primary">طباعة</a>   
                  <a href="{{ route('admin.treasuries.details',$info->id) }}" class="btn btn-sm  btn-info">المزيد</a>   
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
      <br>
      {{ $data->links() }}
      @else
      <div class="alert alert-danger">
         عفوا لاتوجد بيانات لعرضها !!
      </div>
      @endif
   </div>
</div>
</div>
@endsection
@section("script")
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script  src="{{ asset('assets/admin/js/exchange_transaction.js') }}"> </script>
<script>
   //Initialize Select2 Elements
   $('.select2').select2({
     theme: 'bootstrap4'
   });
</script>
@endsection