@extends('layouts.admin')
@section('title')
المناديب
@endsection
@section('contentheader')
الحسابات  
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.accounts.index') }}">    المناديب </a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title card_title_center">بيانات   المناديب  </h3>
      <input type="hidden" id="token_search" value="{{csrf_token() }}">
      <input type="hidden" id="ajax_search_url" value="{{ route('admin.delegates.ajax_search') }}">
      <input type="hidden" id="ajax_search_show" value="{{ route('admin.delegates.show') }}">
      <a href="{{ route('admin.delegates.create') }}" class="btn btn-sm btn-success" >اضافة جديد</a>
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      <div class="row">
         <div class="col-md-4">
            <input  type="radio" checked name="searchbyradio" id="searchbyradio" value="delegate_code"> برقم المندوب
            <input  type="radio"  name="searchbyradio" id="searchbyradio" value="account_number"> برقم الحساب
            <input  type="radio" name="searchbyradio" id="searchbyradio" value="name"> بالاسم
            <input autofocus style="margin-top: 6px !important;" type="text" id="search_by_text" placeholder=" اسم  - رقم الحساب  - كود المندوب" class="form-control"> <br>
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
               <th>  الهاتف </th>
               <th> التفعيل</th>
               <th></th>
            </thead>
            <tbody>
               @foreach ($data as $info )
               <tr>
                  <td>{{ $info->name }}</td>
                  <td>{{ $info->delegate_code }}</td>
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
                  <td>{{ $info->phones }}</td>
                  <td @if($info->active==1) class="bg-success" @else class="bg-danger" @endif>@if($info->active==1) مفعل @else معطل @endif</td> 
                  <td>
                     <a href="{{ route('admin.delegates.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
                     <button data-id="{{ $info->id }}" class="btn btn-sm show_more_details  btn-info">المزيد</button>   
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
<div class="modal fade  "   id="MoreDetailsModal">
   <div class="modal-dialog modal-xl" >
      <div class="modal-content bg-info">
         <div class="modal-header">
            <h4 class="modal-title text-center">               باقي تفاصيل المندوب </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body" id="MoreDetailsModalBody" style="background-color: white !important; color:black;">
         </div>
         <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>
@endsection
@section('script')
<script src="{{ asset('assets/admin/js/delegates.js') }}"></script>
@endsection