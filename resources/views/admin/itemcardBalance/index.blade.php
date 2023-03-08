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
@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title card_title_center">   مرآة كميات الاصناف بالمخازن</h3>
      <input type="hidden" id="token_post" value="{{csrf_token() }}">
      <input type="hidden" id="ajax_url_ajax_search" value="{{ route('admin.itemcardBalance.ajax_search') }}">
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      <div class="row">
         <div class="col-md-4">
            <div class="form-group">
               <label>    بيانات الاصناف</label>
               <select  id="item_code_search" class="form-control select2" style="width: 100%;">
                  <option value="all"> بحث بكل الاصناف</option>
                  @if (@isset($itemCardsSearch) && !@empty($itemCardsSearch))
                  @foreach ($itemCardsSearch as $info )
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
                  @if (@isset($storesSearch) && !@empty($storesSearch))
                  @foreach ($storesSearch as $info )
                  <option value="{{ $info->id }}"> {{ $info->name }} </option>
                  @endforeach
                  @endif
               </select>
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>  حالة الباتشات </label>
               <select name="BatchStatusSerach" id="BatchStatusSerach" class="form-control">
                  <option value="all"> عرض كل الباتشات</option>
                  <option  value="1"> الباتشات التي بها كمية فقط</option>
                  <option  value="2"> الباتشات   الفارغة</option>
               </select>
               @error('active')
               <span class="text-danger">{{ $message }}</span>
               @enderror
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>  أنواع الباتشات </label>
               <select name="BatchTypeSerach" id="BatchTypeSerach" class="form-control">
                  <option value="all"> عرض كل الانواع</option>
                  <option  value="1"> الباتشات الاستهلاكية بتاريخ انتاج  </option>
                  <option  value="2"> الباتشات   الغير استهلاكية</option>
               </select>
               @error('active')
               <span class="text-danger">{{ $message }}</span>
               @enderror
            </div>
         </div>
         <div class="col-md-4">
            <div class="form-group">
               <label>   بحث بحالة الكمية </label>
               <select name="BatchquantitystatusSerach" id="BatchquantitystatusSerach" class="form-control">
                  <option value="all"> عرض كل الكميات</option>
                  <option  value="1"> اكبر من او يساوي    </option>
                  <option  value="2">اصغر من او يساوي</option>
                  <option  value="3"> يساوي</option>
               </select>
               @error('active')
               <span class="text-danger">{{ $message }}</span>
               @enderror
            </div>
         </div>
         <div class="col-md-4" id="BatchquantitySerachDiv" style="display: none;">
            <div class="form-group"> 
               <label>   بحث بالكمية </label>
               <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="BatchquantitySerach" id="BatchquantitySerach" class="form-control"  value=""  >
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
                        @if ( !@empty($info->allBathces) and count($info->allBathces)>0)
                        <table id="example2" class="table table-bordered table-hover">
                           <thead class="bg-info" >
                              <th style="width:20%;">رقم الباتش  </th>
                              <th style="width:20%;">المخزن </th>
                              <th style="width:60%;">  الكمية</th>
                           </thead>
                           <tbody>
                              @foreach ($info->allBathces as $Det )
                              <tr>
                                 <td @if($Det->quantity==0) class="bg-danger"  @endif>{{ $Det->auto_serial }}</td>
                                 <td>{{ $Det->store_name }}</td>
                                 <td >
                                    عدد ( {{ $Det->quantity*1 }} ) {{ $info->Uom_name }}  بإجمالي تكلفة  ( {{ $Det->total_cost_price*1 }} جنيه ) <br>
                                    بسعر  ( {{ $Det->unit_cost_price*(1) }} جنيه ) لوحدة {{ $info->Uom_name }} 
                                    @if($info->does_has_retailunit==1)
                                    <br> 
                                    @if($info->item_type==2)
                                    تاريخ انتاج ( {{ $Det->production_date }} ) <br>
                                    تاريخ انتهاء ( {{ $Det->expired_date }} ) <br>
                                    @endif
                                    <span style="color: brown;"> مايوزاي بوحدة التجزئة</span>
                                    <br>
                                    عدد ( {{ $Det->qunatityRetail*1 }} ) {{ $info->retail_uom_name }} بإجمالي تكلفة  ({{ $Det->total_cost_price*1 }} جنيه) <br>
                                    بسعر  ( {{ $Det->priceRetail*(1) }} جنيه ) لوحدة {{ $info->retail_uom_name }}  
                                    @endif
                                 </td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                        @else
                        <h3 style="text-align: center; font-size:13px; color:brown;">   لاتوجد باتشات لهذا الصنف</h3>
                        @endif
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
<script src="{{ asset('assets/admin/js/itemcardBalance.js') }}"></script>
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script>
   //Initialize Select2 Elements
   $('.select2').select2({
     theme: 'bootstrap4'
   });
</script>
@endsection