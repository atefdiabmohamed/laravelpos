@extends('layouts.admin')
@section('title')
الصلاحيات
@endsection
@section('contentheader')
القوائم الفرعية
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.permission_sub_menues.index') }}">   القوائم الفرعية </a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center">بيانات   القوائم الفرعية للصلاحيات</h3>
            <input type="hidden" id="token_search" value="{{csrf_token() }}">
            <input type="hidden" id="ajax_search_url" value="{{ route('admin.permission_sub_menues.ajax_search') }}">
            <input type="hidden" id="ajax_do_add_permission" value="{{ route('admin.permission_sub_menues.ajax_do_add_permission') }}">
            <input type="hidden" id="ajax_load_edit_permission" value="{{ route('admin.permission_sub_menues.ajax_load_edit_permission') }}">
            <input type="hidden" id="ajax_do_edit_permission" value="{{ route('admin.permission_sub_menues.ajax_do_edit_permission') }}">
            <input type="hidden" id="ajax_do_delete_permission" value="{{ route('admin.permission_sub_menues.ajax_do_delete_permission') }}">
            
            
            <a href="{{ route('admin.permission_sub_menues.create') }}" class="btn btn-sm btn-success" >اضافة جديد</a>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            <div class="row">
               <div class="col-md-4">
                  <label>    بحث بالاسم</label>
                  <input autofocus type="text" id="search_by_text" placeholder="بحث بالاسم" class="form-control"> 
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label>   البحث بالقوائم الرئيسية</label>
                     <select name="permission_main_menues_id_search" id="permission_main_menues_id_search" class="form-control ">
                        <option value="all">البحث بالكل</option>
                        @if (@isset($Permission_main_menues) && !@empty($Permission_main_menues))
                        @foreach ($Permission_main_menues as $info )
                        <option @if(old('permission_main_menues_id')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
                        @endforeach
                        @endif
                     </select>
                     @error('permission_main_menues_id')
                     <span class="text-danger">{{ $message }}</span>
                     @enderror
                  </div>
               </div>
            </div>
            <div class="clearfix"></div>
            <div id="ajax_responce_serarchDiv">
               @if (@isset($data) && !@empty($data) && count($data) >0)
               <table id="example2" class="table table-bordered table-hover">
                  <thead class="custom_thead">
                     <th>كود</th>
                     <th> القائمة الفرعية</th>
                     <th> القائمة الرئيسية </th>
                     <th>حالة التفعيل</th>
                     <th> تاريخ الاضافة</th>
                     <th> تاريخ التحديث</th>
                     <th></th>
                  </thead>
                  <tbody>
                     @foreach ($data as $info )
                     <tr>
                        <td style="background-color: aquamarine;">{{ $info->id}}</td>
                        <td>{{ $info->name }}</td>
                        <td>{{ $info->Permission_main_menues_name }}</td>
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
                           <a href="{{ route('admin.permission_sub_menues.edit',$info->id) }}" class="btn btn-sm  btn-primary">تعديل</a>   
                           <a href="{{ route('admin.permission_sub_menues.delete',$info->id) }}" class="btn are_you_shue btn-sm  btn-danger">حذف</a>   

                           <button data-id="{{ $info->id }}" class="btn btn-sm btn-success load_add_permission_btn"> اضافة صلاحيات </button>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="7">
                           @if (@isset($info->permission_sub_menues_actions) && !@empty($info->permission_sub_menues_actions) && count($info->permission_sub_menues_actions) >0)
                           <table  class="table table-bordered table-hover">
                              <thead class="" style="background-color: lightslategray;color:white">
                                 <th>رقم الصلاحية</th>
                                 <th>  اسم الصلاحية</th>
                                 <th> تاريخ الاضافة</th>
                                 <th> تاريخ التحديث</th>
                                 <th></th>
                              </thead>
                              <tbody>
                                 @foreach ($info->permission_sub_menues_actions as $action )
                                 <tr>
                                    <td >{{ $action->id}}</td>
                                    <td>{{ $action->name }}</td>
                                    <td > 
                                       @php
                                       $dt=new DateTime($action->created_at);
                                       $date=$dt->format("Y-m-d");
                                       $time=$dt->format("h:i");
                                       $newDateTime=date("A",strtotime($time));
                                       $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
                                       @endphp
                                       {{ $date }} <br>
                                       {{ $time }}
                                       {{ $newDateTimeType }}  <br>
                                       بواسطة 
                                       {{ $action->added_by_admin}}
                                    </td>
                                    <td > 
                                       @if($action->updated_by>0 and $action->updated_by!=null )
                                       @php
                                       $dt=new DateTime($action->updated_at);
                                       $date=$dt->format("Y-m-d");
                                       $time=$dt->format("h:i");
                                       $newDateTime=date("A",strtotime($time));
                                       $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
                                       @endphp
                                       {{ $date }}  <br>
                                       {{ $time }}
                                       {{ $newDateTimeType }}  <br>
                                       بواسطة 
                                       {{ $action->updated_by_admin}}
                                       @else
                                       لايوجد تحديث
                                       @endif
                                    </td>
                                    <td>
                                       <button data-id="{{ $action->id }}" class="btn btn-sm btn-info load_edit_permission_btn">  تعديل </button>
                                       <button data-id="{{ $action->id }}" class="btn btn-sm btn-danger do_delete_permisson_btn">  حذف </button>

                                    </td>
                                 </tr>
                                 @endforeach   
                              </tbody>
                           </table>
                           @else
                           <div class="alert alert-danger">
                              عفوا لاتوجد صلاحيات مضافة لعرضها !!
                           </div>
                           @endif
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
</div>
<div class="modal fade  "   id="add_permission_modal">
   <div class="modal-dialog modal-xl"  >
      <div class="modal-content bg-info">
         <div class="modal-header">
            <h4 class="modal-title text-center">         اضافة صلاحيات مهام لهذه القائمة الفرعية</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body" id="add_permission_modalBody" style="background-color: white !important; color:black;">
            <div class="form-group">
               <label>اسم  الصلاحية</label>
               <input name="permission_name_modal" id="permission_name_modal" class="form-control" value="" placeholder="ادخل اسم الصلاحية" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
               @error('name')
               <span class="text-danger">{{ $message }}</span>
               @enderror
            </div>
            <div class="form-group text-center">
               <button id="do_add_permission" type="button"  class="btn btn-primary btn-sm"> اضافة</button>
            </div>
         </div>
         <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>

<div class="modal fade  "   id="edit_permission_modal">
   <div class="modal-dialog modal-xl"  >
      <div class="modal-content bg-info">
         <div class="modal-header">
            <h4 class="modal-title text-center">         تعديل صلاحية مهام </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body" id="edit_permission_modalBody" style="background-color: white !important; color:black;">
      
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
<script src="{{ asset('assets/admin/js/permission_sub_menues.js') }}"></script>
@endsection