@if (@isset($data) && !@empty($data) && count($data) >0)
@php
$i=1;   
@endphp
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
<br>
<div class="col-md-12" id="ajax_pagination_in_search">
   {{ $data->links() }}
</div>
@else
<div class="alert alert-danger">
   عفوا لاتوجد بيانات لعرضها !!
</div>
@endif