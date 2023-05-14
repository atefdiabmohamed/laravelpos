@extends('layouts.admin')
@section('title')
شفتات الخزن
@endsection
@section('contentheader')
حركة الخزنية
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.admin_shift.index') }}">  شفتات الخزن </a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title card_title_center">بيانات  شفتات الخزن للمستخدمين</h3>
      <input type="hidden" id="token_search" value="{{csrf_token() }}">
      <!--  <input type="hidden" id="ajax_search_url" value="{{ route('admin.admin_shift.ajax_search') }}"> -->
     <input type="hidden" id="ajax_review_now_url" value="{{ route('admin.admin_shift.review_now') }}"> 

      @if(empty($checkExistsOpenShift))
      <a href="{{ route('admin.admin_shift.create') }}" class="btn btn-sm btn-success" > فتح شفت جديد</a>
      @endif
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      <div class="row">
         <div class="clearfix"></div>
         <div class="col-md-12">
            <div id="ajax_responce_serarchDiv">
               @if (@isset($data) && !@empty($data) && count($data)>0)
               <table id="example2" class="table table-bordered table-hover">
                  <thead class="custom_thead">
                     <th>كود الشفت</th>
                     <th>اسم المستخدم</th>
                     <th> اسم الخزنة </th>
                     <th> توقيت الفتح</th>
                     <th>  حالة الانتهاء</th>
                     <th>  حالة المراجعة</th>
                     <th></th>
                  </thead>
                  <tbody>
                     @foreach ($data as $info )
                     <tr>
                        <td>{{ $info->id }}
                           @if($info->is_finished==0 and $info->admin_id==auth()->user()->id) 
                           <br>
                           <span style="color:brown"> شفتك الحالي</span>
                           @endif
                        </td>
                        <td>{{ $info->admin_name }}</td>
                        <td>{{ $info->treasuries_name }}</td>
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
                           {{ $newDateTimeType }} 
                        </td>
                        <td>@if($info->is_finished==1)  تم الانتهاء @else  مازال مفتوح @endif</td>
                        <td>@if($info->is_delivered_and_review==1)  تمت المراجعة @else  
                           @if($info->is_finished==1)   بإنتظار المراجعة  
                           @endif
                           @endif
                        </td>
                        <td>
                          
                           @if($info->is_finished==0 and $info->admin_id==auth()->user()->id) 
                           <a href="{{ route('admin.admin_shift.finish',$info->id) }}" class="btn btn-sm  are_you_shue btn-success">  انهاء الشفت</a>   
                           @endif
                           <a target="_blank" href="{{ route('admin.admin_shift.print_details',$info->id) }}" class="btn btn-sm  btn-primary"> طباعة الكشف</a>   
                         
                           @if($info->is_finished==1 and $info->is_delivered_and_review==0  ) 
                           @if (@isset($checkExistsOpenShift) && !@empty($checkExistsOpenShift ) )
                            @if($info->can_review==true)
                           <button data-id={{ $info->id }} class="btn btn-sm  review_now  btn-danger"> مراجعة واستلام</a>   
                           @endif
                           @endif
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

<div class="modal fade  "   id="reviewModal">
   <div class="modal-dialog modal-xl"  >
      <div class="modal-content bg-info">
         <div class="modal-header">
            <h4 class="modal-title text-center">           مراجعة واستلام نقدية شفت خزينة </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body"  style="background-color: white !important; color:black;" id="reviewModalBody">


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
<script src="{{ asset('assets/admin/js/admin_shift.js') }}"></script>
@endsection