@extends('layouts.admin')
@section('title')
الضبط العام
@endsection
@section('contentheader')
الخزن
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.treasuries.index') }}"> الخزن </a>
@endsection
@section('contentheaderactive')
عرض التفاصيل
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center">تفاصيل الخزنة  </h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            @if (@isset($data) && !@empty($data))
            <table id="example2" class="table table-bordered table-hover">
               <tr>
                  <td class="width30">اسم الخزنة</td>
                  <td > {{ $data['name'] }}</td>
               </tr>
               <tr>
                  <td class="width30"> اخر ايصال صرف</td>
                  <td > {{ $data['last_isal_exhcange'] }}</td>
               </tr>
               <tr>
                  <td class="width30">اخر ايصال تحصيل </td>
                  <td > {{ $data['last_isal_collect'] }}</td>
               </tr>
               <tr>
                  <td class="width30">هل رئيسية</td>
                  <td > @if($data['is_master']==1) نعم  @else لا @endif</td>
               </tr>
               <tr>
                  <td class="width30">حالة تفعيل الخزنة</td>
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
                     <a href="{{ route('admin.treasuries.edit',$data['id']) }}" class="btn btn-sm btn-success">تعديل</a>
                     <a href="{{ route('admin.treasuries.index') }}" class="btn btn-sm btn-info">عودة</a>
                  </td>
               </tr>
            </table>
            <!--  treasuries_delivery   -->
            <div class="card-header">
               <h3 class="card-title card_title_center">الخزن الفرعية التي سوف تسلم عهدتها الي الخزنة ( {{ $data['name'] }} )  
                  <a href="{{ route('admin.treasuries.Add_treasuries_delivery',$data['id']) }}" class="btn btn-sm btn-primary">اضافة جديد</a>
               </h3>
            </div>
            <div id="ajax_responce_serarchDiv">
               @if (@isset($treasuries_delivery) && !@empty($treasuries_delivery) && count($treasuries_delivery) >0)
               @php
               $i=1;   
               @endphp
               <table id="example2" class="table table-bordered table-hover">
                  <thead class="custom_thead">
                     <th>مسلسل</th>
                     <th>اسم الخزنة</th>
                     <th>تاريخ الاضافة</th>
                     <th></th>
                  </thead>
                  <tbody>
                     @foreach ($treasuries_delivery as $info )
                     <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $info->name }}</td>
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
                           <a href="{{ route('admin.treasuries.delete_treasuries_delivery',$info->id) }}" class="btn btn-sm btn-danger are_you_shue">حذف</a>
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
         </div>
      </div>
   </div>
</div>
@endsection