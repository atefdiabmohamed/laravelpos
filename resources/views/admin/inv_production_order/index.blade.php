<!-- لاتنسونا من صالح دعائكم -->
@extends('layouts.admin')
@section('title')
حركات خط الاإنتاج
@endsection
@section('contentheader')
اوامر التشغيل
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.inv_production_order.index') }}">  اوامر التشغيل</a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title card_title_center">بيانات   أوامر التشغيل لخطوط الانتاج</h3>
      <input type="hidden" id="token_search" value="{{csrf_token() }}">
      <input type="hidden" id="ajax_search_url" value="{{ route('admin.inv_production_order.ajax_search') }}">
      <input type="hidden" id="ajax_show_more_detials_url" value="{{ route('admin.inv_production_order.show_more_detials') }}">
      <a href="{{ route('admin.inv_production_order.create') }}" class="btn btn-sm btn-success" >اضافة جديد</a>
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      <div class="row">
         <div class="col-md-2">
            <label>    بحث بالكود</label>
            <input type="text" id="search_by_text" placeholder=" " class="form-control"> <br>
         </div>
         <div class="col-md-2">
            <div class="form-group">
               <label>    بحث بالحالة</label>
               <select name="close_search" id="close_search" class="form-control">
                  <option value="all"> بحث بالكل</option>
                  <option  value="0">    مفتوح</option>
                  <option value="1">    مغلق </option>
               </select>
            </div>
         </div>
         <div class="col-md-2">
            <div class="form-group">
               <label>    بحث بالاعتماد</label>
               <select name="approve_search" id="approve_search" class="form-control">
                  <option value="all"> بحث بالكل</option>
                  <option  value="0">    غير معتمد</option>
                  <option value="1">    معتمد </option>
               </select>
            </div>
         </div>
         <div class="col-md-3">
            <div class="form-group">
               <label>      من تاريخ </label>
               <input name="from_date_search" id="from_date_search" class="form-control" type="date" value=""    >
            </div>
         </div>
         <div class="col-md-3">
            <div class="form-group">
               <label>     الي تاريخ  </label>
               <input name="to_date_search" id="to_date_search" class="form-control" type="date" value=""    >
            </div>
         </div>
         <div class="clearfix"></div>
         <div class="col-md-12">
            <div id="ajax_responce_serarchDiv">
               @if (@isset($data) && !@empty($data) && count($data) >0)
               @php
               $i=1;   
               @endphp
               <table id="example2" class="table table-bordered table-hover">
                  <thead class="custom_thead">
                     <th>مسلسل</th>
                     <th>كود </th>
                     <th> تاريخ أمر التشغيل </th>
                     <th>حالة الاعتماد</th>
                     <th>حالة الإغلاق</th>
                     <th> تاريخ الاضافة</th>
                     <th>المزيد</th>
                  </thead>
                  <tbody>
                     @foreach ($data as $info )
                     <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $info->auto_serial }}</td>
                        <td>{{ $info->production_plan_date }}</td>
                        <td>@if($info->is_approved==1)  معتمد
                           <br>
                           @php   $dt=new DateTime($info->approved_at);
                           $date=$dt->format("Y-m-d");
                           $time=$dt->format("h:i");
                           $newDateTime=date("A",strtotime($time));
                           $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
                           @endphp
                           {{ $date }} <br>
                           {{ $time }}
                           {{ $newDateTimeType }}  <br>
                           بواسطة 
                           {{ $info->approved_by_admin}}
                           @else  
                           غير معتمد 
                           <a href="{{ route('admin.inv_production_order.do_approve',$info->id) }}" class="btn are_you_shue btn-sm  btn-success">اعتماد</a>   
                           @endif
                        </td>
                        <td>@if($info->is_closed==1) مغلق ومرحل 
                           <br>
                           @php   $dt=new DateTime($info->closed_at);
                           $date=$dt->format("Y-m-d");
                           $time=$dt->format("h:i");
                           $newDateTime=date("A",strtotime($time));
                           $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
                           @endphp
                           {{ $date }} <br>
                           {{ $time }}
                           {{ $newDateTimeType }}  <br>
                           بواسطة 
                           {{ $info->closed_by_admin}}
                           @else مفتوح 
                           @if($info->is_approved==1)
                           <a href="{{ route('admin.inv_production_order.do_closes_archive',$info->id) }}" class="btn are_you_shue btn-sm  btn-success">اغلاق وترحيل</a>   
                           @endif
                           @endif
                        </td>
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
                           @if($info->is_closed==0) 
                           <a href="{{ route('admin.inv_production_order.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
                           <a href="{{ route('admin.inv_production_order.delete',$info->id) }}" class="btn are_you_shue btn-sm  btn-danger">حذف</a>   
                           @endif
                           <button data-id="{{ $info->id }}" class="btn show_more_detials btn-sm  btn-info">عرض</button>   
                        </td>
                     </tr>
                     @php
                     $i++; 
                     @endphp
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
   </div>
</div>
<div class="modal modal-info" id="show_more_detialsModal">
   <div class="modal-dialog modal-xl" >
      <div class="modal-content modal-info  bg-info">
         <div class="modal-header">
            <div class="modal-body " id="show_more_detialsModalBody" id style="color: black !important;    background: white !important;
               text-align: center;
               font-size: 1.2vw;" >
            </div>
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/admin/js/inv_production_order.js') }}"></script>
@endsection