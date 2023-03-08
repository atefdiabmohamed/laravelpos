@extends('layouts.admin')
@section('title')
جرد المخازن
@endsection
@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('contentheader')
حركات مخزنية
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.stores_inventory.index') }}">   جرد المخازن </a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title card_title_center">  أوامر جرد المخازن </h3>
      <input type="hidden" id="token_search" value="{{csrf_token() }}">
      <input type="hidden" id="ajax_search_url" value="{{ route('admin.stores_inventory.ajax_search') }}">
      <a href="{{ route('admin.stores_inventory.create') }}" class="btn btn-sm btn-success" >اضافة جديد</a>
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      <div class="row">
         <div class="col-md-4">
            <label>بحث بكود الجرد</label>
            <input style="margin-top: 6px !important;" type="text" id="search_by_text"  class="form-control"> <br>
         </div>
         <div class="col-md-4">
            <div class="form-group"   >
               <label>      بحث بالمخازن</label>
               <select name="store_id_search" id="store_id_search" class="form-control ">
                  <option value="all">  بحث بالكل</option>
                  @if (@isset($stores) && !@empty($stores))
                  @foreach ($stores as $info )
                  <option  value="{{ $info->id }}"> {{ $info->name }} </option>
                  @endforeach
                  @endif
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>    بحث بنوع الجرد</label>
               <select name="inventory_type_search" id="inventory_type_search" class="form-control">
                  <option value="all">   بحث بالكل </option>
                  <option value="1">   جرد يومي</option>
                  <option value="2">   جرد اسبوعي</option>
                  <option value="3">   جرد شهري</option>
                  <option  value="4">   جرد سنوي</option>
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>    حالة امر الجرد</label>
               <select name="is_closed_search" id="is_closed_search" class="form-control">
                  <option value="all">بحث بكل الحالات</option>
                  <option   value="1"> مغلق</option>
                  <option value="0"> غير مغلق</option>
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>   بحث  من تاريخ</label>
               <input name="order_date_form" id="order_date_form" class="form-control" type="date" value=""    >
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>   بحث  الي تاريخ</label>
               <input name="order_date_to" id="order_date_to" class="form-control" type="date" value=""    >
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
                     <th>كود</th>
                     <th> تاريخ الجرد</th>
                     <th>نوع الجرد</th>
                     <th> مخزن الجرد</th>
                     <th>  حالة الجرد</th>
                     <th> تاريخ الاضافة</th>
                     <th></th>
                  </thead>
                  <tbody>
                     @foreach ($data as $info )
                     <tr>
                        <td>{{ $info->auto_serial }}</td>
                        <td>{{ $info->inventory_date }}</td>
                        <td>
                           @if($info->inventory_type==1)جرد يومي 
                           @elseif($info->inventory_type==2)جرد اسبوعي  
                           @elseif($info->inventory_type==3)جرد شهري  
                           @elseif($info->inventory_type==4)جرد سنوي  
                           @else     لم يحدد @endif
                        </td>
                        <td>{{ $info->store_name }}</td>
                        <td>@if($info->is_closed==1)  مغلق ومرحل   @else   مفتوح @endif</td>
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
                           <a href="{{ route('admin.stores_inventory.edit',$info->id) }}" class="btn btn-sm  btn-success">تعديل</a>   
                           <a href="{{ route('admin.stores_inventory.delete',$info->id) }}" class="btn btn-sm are_you_shue  btn-danger">حذف</a>   
                           @endif
                           <a href="{{ route('admin.stores_inventory.show',$info->id) }}" class="btn btn-sm   btn-info">التفاصيل</a>   
                           <a style="font-size: .875rem; padding: 0.25rem 0.5rem;color:white" target="_blank" href="{{ route('admin.stores_inventory.printsaleswina4',[$info->id,'A4']) }}" class="btn btn-primary btn-xs"> WA4</a>
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
<script src="{{ asset('assets/admin/js/inv_stores_inventory.js') }}"></script>
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script>
   //Initialize Select2 Elements
   $('.select2').select2({
     theme: 'bootstrap4'
   });
</script>
@endsection