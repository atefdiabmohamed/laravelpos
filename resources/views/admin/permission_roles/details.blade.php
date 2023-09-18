@extends('layouts.admin')
@section('title')
الصلاحيات
@endsection
@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('contentheader')
الأدوار
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.permission_roles.index') }}">  أدوار المستخدمين </a>
@endsection
@section('contentheaderactive')
عرض التفاصيل
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center">تفاصيل دور الصلاحية  </h3>
            <input type="hidden" id="token_search" value="{{csrf_token() }}">
            <input type="hidden" id="ajax_search_load_add_permission_roles_sub_menu" value="{{ route('admin.permission_roles.load_add_permission_roles_sub_menu') }}">
            <input type="hidden" id="ajax_search_load_add_permission_roles_sub_menues_actions" value="{{ route('admin.permission_roles.load_add_permission_roles_sub_menues_actions') }}">
      
            
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            @if (@isset($data) && !@empty($data))
            <table id="example2" class="table table-bordered table-hover">
               <tr>
                  <td class="width30">اسم الدور</td>
                  <td > {{ $data['name'] }}</td>
               </tr>
             
      
               <tr>
                  <td class="width30">حالة تفعيل الدور</td>
                  <td > @if($data['active']==1) مفعل  @else معطل @endif</td>
               </tr>
               <tr>
                  <td class="width30">  تاريخ  الاضافة</td>
                  <td > 
                     @php
                     $dt=new DateTime($data['created_at']);
                     $date=$dt->format("Y-m-d");
                     $time=$dt->format("h:i");
                     $newDateTime=date("A",strtotime($time));
                     $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
                     @endphp
                     {{ $date }}
                     {{ $time }}
                     {{ $newDateTimeType }}
                     بواسطة 
                     {{ $data['added_by_admin'] }}
                  </td>
               </tr>
               <tr>
                  <td class="width30">  تاريخ اخر تحديث</td>
                  <td > 
                     @if($data['updated_by']>0 and $data['updated_by']!=null )
                     @php
                     $dt=new DateTime($data['updated_at']);
                     $date=$dt->format("Y-m-d");
                     $time=$dt->format("h:i");
                     $newDateTime=date("A",strtotime($time));
                     $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
                     @endphp
                     {{ $date }}
                     {{ $time }}
                     {{ $newDateTimeType }}
                     بواسطة 
                     {{ $data['updated_by_admin'] }}
                     @else
                     لايوجد تحديث
                     @endif
                     <a href="{{ route('admin.permission_roles.edit',$data['id']) }}" class="btn btn-sm btn-success">تعديل</a>
                     <a href="{{ route('admin.permission_roles.index') }}" class="btn btn-sm btn-info">عودة</a>
                  </td>
               </tr>
            </table>
            <!--  treasuries_delivery   -->
            <div class="card-header">
               <h3 class="card-title card_title_center">القوائم الرئيسية المضافة لصلاحية الدور ( {{ $data['name'] }} )  
                  <button  class="btn btn-sm btn-primary"    data-toggle="modal" data-target="#Add_permission_main_menuesModal">اضافة قائمة </button>
               </h3>
            </div>
            <div id="ajax_responce_serarchDiv">
               @if (@isset($permission_roles_main_menus) && !@empty($permission_roles_main_menus) && count($permission_roles_main_menus) >0)
               @php
               $i=1;   
               @endphp
             
                     @foreach ($permission_roles_main_menus as $info )
                     <table id="example2" class="table table-bordered table-hover">
                        <thead class="custom_thead">
                         
                           <th>اسم القائمة الرئيسية</th>
                           <th>تاريخ الاضافة</th>
                           <th></th>
                        </thead>
                        <tbody>
                     <tr>
                     
                        <td>{{ $info->permission_main_menues_name }}</td>
                        <td > 
                           @php
                           $dt=new DateTime($info->created_at);
                           $date=$dt->format("Y-m-d");
                           $time=$dt->format("h:i");
                           $newDateTime=date("A",strtotime($time));
                           $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
                           @endphp
                           {{ $date }}
                           {{ $time }}
                           {{ $newDateTimeType }}
                           بواسطة 
                           {{ $info->added_by_admin}}
                        </td>
                        <td>
                           <a href="{{ route('admin.permission_roles.delete_permission_main_menues',$info->id) }}" class="btn btn-sm btn-danger are_you_shue">حذف</a>
                        </td>
                     </tr>
                     <tr>
                       <td colspan="3"> 
                      <p style="text-align: center; font-size: 1.4vw; color: brown"> القوائم الفرعية المضافة لهذه القائمة الرئيسية
                     
                        <button data-id="{{ $info->id }}"  class="btn btn-sm load_add_permission_roles_sub_menu btn-info" >اضافة قائمة فرعية </button>

                     
                     </p>  
                     @if (@isset($info->permission_roles_sub_menu) && !@empty($info->permission_roles_sub_menu) && count($info->permission_roles_sub_menu) >0)
                     <table id="example2" class="table table-bordered table-hover">
                        <thead class="bg-info">
                         
                           <th>اسم القائمة الفرعية</th>
                           <th>تاريخ الاضافة</th>
                           <th></th>
                        </thead>
                        <tbody>
                   @foreach ($info->permission_roles_sub_menu as $sub )
                   <tr>
                     
                     <td>{{ $sub->permission_sub_menues_name }}</td>
                     <td > 
                        @php
                        $dt=new DateTime($sub->created_at);
                        $date=$dt->format("Y-m-d");
                        $time=$dt->format("h:i");
                        $newDateTime=date("A",strtotime($time));
                        $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
                        @endphp
                        {{ $date }}
                        {{ $time }}
                        {{ $newDateTimeType }}
                        بواسطة 
                        {{ $sub->added_by_admin}}
                     </td>
                     <td>
                        <button data-id="{{ $sub->id }}"  class="btn btn-sm load_add_permission_roles_sub_menues_actions btn-success" >اضافة صلاحيات مباشرة  </button>
      
                        <a href="{{ route('admin.permission_roles.delete_permission_sub_menues',$sub->id) }}" class="btn btn-sm btn-danger are_you_shue">حذف</a>
                     </td>
                  </tr>
                  <tr>
                    <td colspan="3" style="text-align: center">
                     @if (@isset($sub->permission_roles_sub_menues_actions) && !@empty($sub->permission_roles_sub_menues_actions) && count($sub->permission_roles_sub_menues_actions) >0)
                   @foreach ( $sub->permission_roles_sub_menues_actions as $action)
    <a style="    background-color: mediumvioletred;" href="{{ route('admin.permission_roles.delete_permission_sub_menues_actions',$action->id) }}" class="btn btn-sm btn-primary are_you_shue">{{ $action->permission_sub_menues_actions_name }} <i class="fa fa-trash" aria-hidden="true"></i></a>
   




                   @endforeach

                     @endif
                  </td> 
                  </tr>




                       @endforeach
                     </tbody>
                  </table>
                     @else
            <div class="alert alert-danger">
               عفوا لاتوجد بيانات لعرضها !!
            </div>
            @endif

                     </td> 
                     </tr>
                     @php
                     $i++; 
                     @endphp
                        </tbody>
                     </table>
                     @endforeach
               
               @else
               <div class="alert alert-danger">
                  عفوا لاتوجد بيانات لعرضها !!
               </div>
               @endif
            </div>
            <!--  End treasuries_delivery   -->
            @else
            <div class="alert alert-danger">
               عفوا لاتوجد بيانات لعرضها !!
            </div>
            @endif
         </div>
      </div>
   </div>
</div>

<div class="modal fade  "   id="Add_permission_main_menuesModal">
   <div class="modal-dialog modal-xl"  >
      <div class="modal-content bg-info">
         <div class="modal-header">
            <h4 class="modal-title text-center">           اضافة قائمة رئيسية للدور</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body"  style="background-color: white !important; color:black;">
            <form action="{{ route('admin.permission_roles.Add_permission_main_menues',$data['id']) }}" method="post" >
               @csrf

               <div class="form-group">
                  <label>   بيانات القوائم الرئيسية</label>
                  <select required name="permission_main_menues_id[]" multiple  id="permission_main_menues_id" class="form-control select2">
                     <option value="">اختر القائمة الرئيسية لها</option>
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
         

            
            <div class="form-group text-center">
               <button type="submit" class="btn btn-primary btn-sm"> اضافة</button>
               <a href="{{ route('admin.uoms.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
            </div>
            </form>
         </div>
         <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>



<div class="modal fade  "   id="load_add_permission_roles_sub_menuModal">
   <div class="modal-dialog modal-xl"  >
      <div class="modal-content bg-info">
         <div class="modal-header">
            <h4 class="modal-title text-center">           اضافة قائمة فرعية للقائمة الرئيسية</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body"  style="background-color: white !important; color:black;" id="load_add_permission_roles_sub_menuModalBody">

         </div>
         <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>


<div class="modal fade  "   id="load_add_permission_roles_sub_menues_actionsModal">
   <div class="modal-dialog modal-xl"  >
      <div class="modal-content bg-info">
         <div class="modal-header">
            <h4 class="modal-title text-center">           اضافة صلاحيات مباشرة للقائمة الفرعية</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body"  style="background-color: white !important; color:black;" id="load_add_permission_roles_sub_menues_actionsModalBody">


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
@section("script")
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script src="{{ asset('assets/admin/js/permission_roles.js') }}"></script>

<script>
   //Initialize Select2 Elements
   $('.select2').select2({
     theme: 'bootstrap4'
   });
</script>
@endsection