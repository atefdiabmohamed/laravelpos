@extends('layouts.admin')
@section('title')
الخدمات الداخلية والخارجية
@endsection
@section('contentheader')
الخدمات
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.uoms.index') }}">  الخدمات الداخلية والخارجية </a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title card_title_center">بيانات   الخدمات</h3>
      <input type="hidden" id="token_search" value="{{csrf_token() }}">
      <input type="hidden" id="ajax_search_url" value="{{ route('admin.Services.ajax_search') }}">
      <a href="{{ route('admin.Services.create') }}" class="btn btn-sm btn-success" >اضافة جديد</a>
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      <div class="row">
         <div class="col-md-4">
            <label>    بحث بالاسم</label>
            <input type="text" id="search_by_text" placeholder="بحث بالاسم" class="form-control"> <br>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>    بحث بالنوع</label>
               <select name="type_search" id="type_search" class="form-control">
                  <option value="all"> بحث بالكل</option>
                  <option  value="1">  خدمات مقدمة لنا</option>
                  <option value="2">  خدمات نقدمها للغير</option>
               </select>
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
                     <th>اسم الخدمة</th>
                     <th> نوع الخدمة</th>
                     <th>حالة التفعيل</th>
                     <th> تاريخ الاضافة</th>
                     <th> تاريخ التحديث</th>
                     <th></th>
                  </thead>
                  <tbody>
                     @foreach ($data as $info )
                     <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $info->name }}</td>
                        <td>@if($info->type==1)  خدمات مقدمة لنا @else  خدمات نقدمها للغير @endif</td>
                        <td>@if($info->active==1) مفعل @else معطل @endif</td>
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
                        <td > 
                           @if($info->updated_by>0 and $info->updated_by!=null )
                           @php
                           $dt=new DateTime($info->updated_at);
                           $date=$dt->format("Y-m-d");
                           $time=$dt->format("h:i");
                           $newDateTime=date("A",strtotime($time));
                           $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
                           @endphp
                           {{ $date }}  <br>
                           {{ $time }}
                           {{ $newDateTimeType }}  <br>
                           بواسطة 
                           {{ $data['updated_by_admin'] }}
                           @else
                           لايوجد تحديث
                           @endif
                        </td>
                        <td>
                           <a href="{{ route('admin.Services.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
                           <a href="{{ route('admin.Services.delete',$info->id) }}" class="btn are_you_shue btn-sm  btn-danger">حذف</a>   
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
@endsection
@section('script')
<script src="{{ asset('assets/admin/js/services.js') }}"></script>
@endsection