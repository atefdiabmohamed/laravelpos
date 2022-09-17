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
        <!--  <input type="hidden" id="ajax_search_url" value="{{ route('admin.uoms.ajax_search') }}"> -->
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
              
              @endif</td> 
         
         <td>


        <a href="{{ route('admin.uoms.edit',$info->id) }}" class="btn btn-sm  btn-primary"> طباعة الكشف</a>   
        <a href="{{ route('admin.uoms.delete',$info->id) }}" class="btn btn-sm are_you_shue  btn-danger">كشف مختصر</a>   
   
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





@endsection

@section('script')
<script src="{{ asset('assets/admin/js/inv_uoms.js') }}"></script>

@endsection


