@extends('layouts.admin')
@section('title')
حركات مخزنية
@endsection

@section('contentheader')
ارصدة الاصناف
@endsection

@section('contentheaderlink')
<a href="{{ route('admin.itemcardBalance.index') }}">  الأرصدة </a>
@endsection

@section('contentheaderactive')
عرض
@endsection



@section('content')


  
      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">   مرآة كميات الاصناف بالمخازن</h3>
          <input type="hidden" id="token_search" value="{{csrf_token() }}">
        
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group"> 
                <label>    بيانات الاصناف</label>

                <select  id="item_code_search" class="form-control select2" style="width: 100%;">
                  <option value="all"> بحث بكل الاصناف</option>
                  @if (@isset($item_cards) && !@empty($item_cards))
                 @foreach ($item_cards as $info )
                   <option data-item_type="{{ $info->item_type }}"  
                      value="{{ $info->item_code }}"> {{ $info->name }} 
                    </option>
                 @endforeach
                  @endif
                </select>
              
                </div>
             </div>
             <div class="col-md-4" >
              <div class="form-group"> 
                <label>    بيانات المخازن</label>
                <select name="store_id_search" id="store_id_search" class="form-control ">
                  <option value="all">  بحث بكل المخازن  </option>
                  @if (@isset($stores) && !@empty($stores))
                  @php $i=1;  @endphp
                 @foreach ($stores as $info )
                   <option @if($i==1) selected @endif value="{{ $info->id }}"> {{ $info->name }} </option>
                   @php $i++;  @endphp
                 @endforeach
                  @endif
                </select>
             
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group"> 
                  <label>  حالة الباتشات </label>
                  <select name="BatchStatusSerach" id="BatchStatusSerach" class="form-control">
                   <option value="1"> عرض كل الباتشات</option>
                  <option  value="2"> الباتشات التي بها كمية فقط</option>
                  </select>
                  @error('active')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                  </div>
                </div>        
                    

               <div class="clearfix"></div>

        <div id="ajax_responce_serarchDiv" class="col-md-12">
          
          @if (@isset($allitemscardData) && !@empty($allitemscardData))
          @php
           $i=1;   
          @endphp
          <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
              <th style="width:10%;">كود  </th>
           <th style="width:20%;">الاسم </th>
          
           <th style="width:70%;"> الكميات بالمخازن</th>
         
 

            </thead>
            <tbody>
         @foreach ($allitemscardData as $info )
            <tr>
             <td>{{ $info->item_code }}</td>  
             <td>{{ $info->name }}</td>  
             <td>
             كل الكمية بالمخازن (  {{ $info->All_QUENTITY*1 }} {{ $info->Uom_name }}  ) <br> <br>
             <h3 style="text-align: center; font-size:15px; color:brown;">تفاصيل كميات الصنف بالمخازن</h3>



             </td>
           </tr> 
         


      @php
         $i++; 
      @endphp
         @endforeach
   
   
   
            </tbody>
             </table>
             
      <br>
           {{ $allitemscardData->links() }}
       
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
<script src="{{ asset('assets/admin/js/inv_itemcard.js') }}"></script>

@endsection


