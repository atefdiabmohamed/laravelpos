@if($invoice_data['is_approved']==0)
<input type="hidden" id="invoiceautoserial" value="{{ $invoice_data['auto_serial']  }}">
@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection
                <div class="row">
                  <div class="col-md-4">
                   <div class="form-group"> 
                     <label>    تاريخ الفاتورة</label>
                    <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="{{ $invoice_data['invoice_date'] }}">
                     </div>
                  </div>
                  <div class="col-md-4" >
                    <div class="form-group"> 
                     <label>    فئات الفواتير</label>
                     <select name="Sales_matrial_types_id" id="Sales_matrial_types_id" class="form-control select2">
                       <option value="">  اختر فئة الفاتورة</option>
                       @if (@isset($Sales_matrial_types) && !@empty($delegates))
                      @foreach ($Sales_matrial_types as $info )
                        <option @if($invoice_data['sales_matrial_types']==$info->id) selected @endif  value="{{ $info->id }}"> {{ $info->name }} </option>
                      @endforeach
                       @endif
                     </select>
                   
                     </div>
 
                   </div>
                  <div class="col-md-4">
                    <div class="form-group"> 
                      <label>      هل يوجد عميل</label>
             <select name="is_has_customer" id="is_has_customer" class="form-control" >
             <option @if($invoice_data['is_has_customer']==1) selected @endif value="1" selected> نعم  عميل</option>
             <option @if($invoice_data['is_has_customer']==0) selected @endif value="0" > لايوجد عميل( طياري )</option>

             </select>

                      </div>
                   </div>
                   <div class="col-md-4" id="customer_codeDiv" >
                   <div class="form-group"> 
                    <label>   بيانات العملاء
                     (<a title=" اضافة عميل جديد " href="#">جديد <i   class="fa fa-plus-circle  "></i> </a>) 
                    </label>
                    <select name="customer_code" id="customer_code" class="form-control select2">
                      <option value=""> لايوجد عميل</option>
                      @if (@isset($customers) && !@empty($customers))
                     @foreach ($customers as $info )
                       <option @if($invoice_data['customer_code']==$info->customer_code and $invoice_data['is_has_customer']==1) selected @endif  value="{{ $info->customer_code }}"> {{ $info->name }} </option>
                     @endforeach
                      @endif
                    </select>
                  
                    </div>

                  </div>

                  <div class="col-md-4" >
                    <div class="form-group"> 
                     <label>   بيانات المناديب</label>
                     <select name="delegate_code" id="delegate_code" class="form-control select2">
                       <option value="">  اختر المندوب</option>
                       @if (@isset($delegates) && !@empty($delegates))
                      @foreach ($delegates as $info )
                        <option  @if($invoice_data['delegate_code']==$info->delegate_code) selected @endif  value="{{ $info->delegate_code }}"> {{ $info->name }} </option>
                      @endforeach
                       @endif
                     </select>
                   
                     </div>
 
                   </div>

                </div>
                   <hr style="border:1px solid #3c8dbc;">  
                   <div class="row">
                     <div class="col-md-3" >
                     <div class="form-group"> 
                       <label>    بيانات المخازن</label>
                       <select name="store_id" id="store_id" class="form-control ">
                         <option value=""> اختر المخزن  </option>
                         @if (@isset($stores) && !@empty($stores))
                        @foreach ($stores as $info )
                          <option value="{{ $info->id }}"> {{ $info->name }} </option>
                        @endforeach
                         @endif
                       </select>
                    
                       </div>
                     </div>
   
                     <div class="col-md-3" >
                       <div class="form-group"> 
                        <label>    نوع البيع</label>
                        <select name="sales_item_type" id="sales_item_type" class="form-control ">
                       <option value="1">قطاعي</option>
                       <option value="2">نص جملة</option>
                       <option value="3">جملة</option>
                     </select>
                      
                        </div>
                      </div>
                      <div class="col-md-3">
                       <div class="form-group"> 
                         <label>   بيانات الاصناف</label>
                         <select  id="item_code" class="form-control select2" style="width: 100%;">
                           <option value="">اختر الصنف</option>
                           @if (@isset($item_cards) && !@empty($item_cards))
                          @foreach ($item_cards as $info )
                            <option data-item_type="{{ $info->item_type }}"  
   
                               value="{{ $info->item_code }}"> {{ $info->name }} 
                             
                             </option>
                          @endforeach
                           @endif
                         </select>
                         @error('suuplier_code')
                         <span class="text-danger">{{ $message }}</span>
                         @enderror
                         </div>
                      </div>
                      
                 <!--  الوحدات للصنف-->
                      <div class="col-md-3  " style="display: none;" id="UomDiv">
       
                     </div>
     <!--   باتشات الكميات بالمخازن-->
     <div class="col-md-6  " style="display: none;" id="inv_itemcard_batchesDiv">
       
     </div>
   
                     <div class="col-md-3  "
                     <div class="form-group">
                       <label> الكمية</label>
                       <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="item_quantity" id="item_quantity" class="form-control"  value="1"   >
                       </div>
                       <div class="col-md-3  "
                       <div class="form-group">
                         <label> السعر</label>
                         <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="item_price" id="item_price" class="form-control"  value=""   >
                         </div>
                         <div class="col-md-3" >
                           <div class="form-group"> 
                            <label> هل بيع عادي</label>
                            <select name="is_normal_orOther" id="is_normal_orOther" class="form-control ">
                           <option value="1">عادي</option>
                           <option value="2">بونص </option>
                           <option value="3">دعاية</option>
                           <option value="4">هالك</option>
   
                         </select>
                          
                            </div>
                          </div>
   
                         <div class="col-md-3  "
                         <div class="form-group">
                           <label> الاجمالي</label>
                           <input readonly oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="item_total" id="item_total" class="form-control"  value=""   >
                           </div>
                           <div class="col-md-2  "
                           <div class="form-group">
                         <button style="margin-top:35px" class="btn btn-sm btn-danger" id="AddItemToIvoiceDetailsActive">أضف الصنف فعليا </button>  
                             </div>
                     </div> 
                     <div class="clearfix"></div>
                     <hr style="border:1px solid #3c8dbc;">  

                     <div class="row"  id="invoiceitemsDiv">
                      <h3 class="card-title card_title_center">       الاصناف المضافة علي الفاتورة  </h3>
  
                      <table id="example2" class="table table-bordered table-hover">
                        <thead class="custom_thead"> 
                          <th>المخزن</th>
                          <th>نوع البيع</th>
                          <th>الصنف</th>
                          <th>وحدة البيع</th>
                          <th>سعر الوحدة</th>
                          <th>الكمية</th>
                          <th>الاجمالي</th>
                          <th></th>
                        </thead>
                        <tbody id="itemsrowtableContainterBody">
  
                        </tbody>
  
                      </table>
  
                    </div>
                    <div class="clearfix"></div>
                    <hr style="border:1px solid #3c8dbc;"> 


            

            

  @section("script")

<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script>
  //Initialize Select2 Elements
  $('.select2').select2({
    theme: 'bootstrap4'
  });
  </script>


@else
<div class="alert alert-danger">
عفوا لايمكن التعديل علي فاتورة معتمده وتم ترحيلها !!!!
</div>
      @endif
                


  
              
              
