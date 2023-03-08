@extends('layouts.admin')
@section('title')
خطوط الانتاج
@endsection
@section('contentheader')
خطوط الانتاج  
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.inv_production_lines.index') }}">    ورش الانتاج </a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title card_title_center">بيانات   خطوط الانتاج (الورش)  </h3>
      <input type="hidden" id="token_search" value="{{csrf_token() }}">
      <input type="hidden" id="ajax_search_url" value="{{ route('admin.inv_production_lines.ajax_search') }}">
      <a href="{{ route('admin.inv_production_lines.create') }}" class="btn btn-sm btn-success" >اضافة جديد</a>
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      <div class="row">
         <div class="col-md-4">
            <input  type="radio" checked name="searchbyradio" id="searchbyradio" value="production_lines_code"> برقم الخط
            <input  type="radio"  name="searchbyradio" id="searchbyradio" value="account_number"> برقم الحساب
            <input  type="radio" name="searchbyradio" id="searchbyradio" value="name"> بالاسم
            <input autofocus style="margin-top: 6px !important;" type="text" id="search_by_text" placeholder=" اسم  - رقم الحساب  - كود الخط" class="form-control"> <br>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>  بحث بحالة الرصيد</label>
               <select name="searchByBalanceStatus" id="searchByBalanceStatus" class="form-control">
                  <option   value="all"> بحث بالكل</option>
                  <option   value="1"> دائن</option>
                  <option  value="2"> مدين</option>
                  <option    value="3"> متزن</option>
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>  بحث بحالة التفعيل</label>
               <select name="searchByactiveStatus" id="searchByactiveStatus" class="form-control">
                  <option   value="all"> بحث بالكل</option>
                  <option   value="1"> مفعل</option>
                  <option  value="0"> معطل</option>
               </select>
            </div>
         </div>
      </div>
      <div class="clearfix"></div>
      <div id="ajax_responce_serarchDiv" class="col-md-12">
         @if (@isset($data) && !@empty($data) && count($data)>0)
         <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
               <th>الاسم </th>
               <th>  الكود </th>
               <th> رقم الحساب </th>
               <th>  الرصيد </th>
               <th>  العنوان </th>
               <th>  الهاتف </th>
               <th>  ملاحظات </th>
               <th> التفعيل</th>
               <th></th>
            </thead>
            <tbody>
               @foreach ($data as $info )
               <tr>
                  <td>{{ $info->name }}</td>
                  <td>{{ $info->production_lines_code }}</td>
                  <td>{{ $info->account_number }}</td>
                  <td> 
                     @if($info->current_balance >0)
                     مدين ب ({{ $info->current_balance*1 }}) جنيه  
                     @elseif ($info->current_balance <0)
                     دائن ب ({{ $info->current_balance*1*(-1) }})   جنيه
                     @else
                     متزن
                     @endif
                  </td>
                  <td>{{ $info->address }}</td>
                  <td>{{ $info->phones }}</td>
                  <td>{{ $info->notes }}</td>
                  <td>@if($info->active==1) مفعل @else معطل @endif</td>
                  <td>
                     <a href="{{ route('admin.inv_production_lines.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
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
</div>
@endsection
@section('script')
<script src="{{ asset('assets/admin/js/inv_production_lines.js') }}"></script>
@endsection