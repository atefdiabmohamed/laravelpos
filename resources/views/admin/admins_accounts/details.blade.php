@extends('layouts.admin')
@section('title')
المستخدمين
@endsection
@section('contentheader')
المستخدمين
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.admins_accounts.index') }}"> المستخدمين </a>
@endsection
@section('contentheaderactive')
التفاصيل
@endsection
@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center">تفاصيل الصلاحيات الخاصة للمستخدم   </h3>
            <input type="hidden" id="token_search" value="{{csrf_token() }}">
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            @if (@isset($data) && !@empty($data))
            <table id="example2" class="table table-bordered table-hover">
               <tr>
                  <td class="width30">اسم المستخدم</td>
                  <td > {{ $data['name'] }}</td>
               </tr>
               <tr>
                  <td class="width30"> نوع صلاحية دور المستخدم</td>
                  <td > {{ $data['permission_roles_name'] }}</td>
               </tr>
               <tr>
                  <td class="width30">البريد الالكتروني</td>
                  <td > {{ $data['email'] }}</td>
               </tr>
               <tr>
                  <td class="width30">حالة تفعيل المستخدم</td>
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
                     <a href="{{ route('admin.admins_accounts.edit',$data['id']) }}" class="btn btn-sm btn-success">تعديل</a>
                     <a href="{{ route('admin.admins_accounts.index') }}" class="btn btn-sm btn-info">عودة</a>
                  </td>
               </tr>
            </table>
            <!--  treasuries_delivery   -->
            <div class="card-header">
               <h3 class="card-title card_title_center">الخزن  المضافة لصلاحية المستخدم ( {{ $data['name'] }} )  
                  <button  class="btn btn-sm btn-primary"    data-toggle="modal" data-target="#Add_treasuriesModal">اضافة خزن </button>
               </h3>
            </div>
            <div id="ajax_responce_serarchDiv">
               @if (@isset($admins_treasuries) && !@empty($admins_treasuries) && count($admins_treasuries) >0)
               @php
               $i=1;   
               @endphp
               <table id="example2" class="table table-bordered table-hover">
                  <thead class="custom_thead">
                     <th>اسم  الخزنة</th>
                     <th>تاريخ الاضافة</th>
                     <th></th>
                  </thead>
                  <tbody>
                     @foreach ($admins_treasuries as $info )
                     <tr>
                        <td>{{ $info->treasuries_name }}</td>
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
                           <a href="{{ route('admin.admins_accounts.delete_treasuries',['rowid'=>$info->id,'userid'=>$data['id'] ]) }}" class="btn btn-sm btn-danger are_you_shue">حذف</a>
                        </td>
                     </tr>
                     @php
                     $i++; 
                     @endphp
                     @endforeach
                  </tbody>
               </table>
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


 <!--  stores   -->
 <div class="card-header">
   <h3 class="card-title card_title_center">المخازن  المضافة لصلاحية المستخدم ( {{ $data['name'] }} )  
      <button  class="btn btn-sm btn-primary"    data-toggle="modal" data-target="#Add_storesModal">اضافة مخازن </button>
   </h3>
</div>
<div id="ajax_responce_serarchDiv">
   @if (@isset($admins_stores) && !@empty($admins_stores) && count($admins_stores) >0)
   @php
   $i=1;   
   @endphp
   <table id="example2" class="table table-bordered table-hover">
      <thead class="custom_thead">
         <th>اسم  المخزن</th>
         <th>تاريخ الاضافة</th>
         <th></th>
      </thead>
      <tbody>
         @foreach ($admins_stores as $info )
         <tr>
            <td>{{ $info->store_name }}</td>
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
               <a href="{{ route('admin.admins_accounts.delete_stores',['rowid'=>$info->id,'userid'=>$data['id'] ]) }}" class="btn btn-sm btn-danger are_you_shue">حذف</a>
            </td>
         </tr>
         @php
         $i++; 
         @endphp
         @endforeach
      </tbody>
   </table>
   @else
   <div class="alert alert-danger">
      عفوا لاتوجد بيانات لعرضها !!
   </div>
   @endif
</div>
<!--  End stores   -->




         </div>
      </div>
   </div>
</div>

<div class="modal fade  "   id="Add_treasuriesModal">
   <div class="modal-dialog modal-xl"  >
      <div class="modal-content bg-info">
         <div class="modal-header">
            <h4 class="modal-title text-center">           اضافة خزن لصلاحية المستخدم</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body"  style="background-color: white !important; color:black;" >
            <form action="{{ route('admin.admins_accounts.add_treasuries',$data['id']) }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>   بيانات  الخزن</label>
                  <select name="treasuries_ids[]" multiple id="treasuries_ids" required oninvalid="setCustomValidity('من فضلك   اختر الخزن')" onchange="try{setCustomValidity('')}catch(e){}" class="form-control select2 ">
                     <option value="">اختر الخزن  </option>
                     @if (@isset($treasuries) && !@empty($treasuries))
                     @foreach ($treasuries as $info )
                     <option  value="{{ $info->id }}" > {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
               </div>
               <div class="form-group text-center">
                  <button type="submit" class="btn btn-primary btn-sm"> اضافة</button>
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


<div class="modal fade "   id="Add_storesModal">
   <div class="modal-dialog modal-xl"  >
      <div class="modal-content bg-info">
         <div class="modal-header">
            <h4 class="modal-title text-center">           اضافة مخازن لصلاحية المستخدم</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body"  style="background-color: white !important; color:black;" >
            <form action="{{ route('admin.admins_accounts.add_stores',$data['id']) }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>   بيانات  الخزن</label>
                  <select name="stores_ids[]" multiple id="stores_ids" required oninvalid="setCustomValidity('من فضلك   اختر الخزن')" onchange="try{setCustomValidity('')}catch(e){}" class="form-control select2 ">
                     <option value="">اختر الخزن  </option>
                     @if (@isset($stores) && !@empty($stores))
                     @foreach ($stores as $info )
                     <option  value="{{ $info->id }}" > {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
               </div>
               <div class="form-group text-center">
                  <button type="submit" class="btn btn-primary btn-sm"> اضافة</button>
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

@endsection
@section("script")
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script src="{{ asset('assets/admin/js/admins.js') }}"></script>
<script>
   //Initialize Select2 Elements
   $('.select2').select2({
        theme: 'bootstrap4'
      });
</script>
@endsection