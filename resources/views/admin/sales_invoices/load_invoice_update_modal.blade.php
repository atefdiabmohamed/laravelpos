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
         <label>    نوع الفاتورة</label>
         <select @if(!@empty($sales_invoices_details) and count($sales_invoices_details)>0) disabled @endif        name="sales_item_type_mainUpdate" id="sales_item_type_mainUpdate" class="form-control ">
         <option @if($invoice_data['sales_item_type']==1) selected @endif value="1">قطاعي</option>
         <option  @if($invoice_data['sales_item_type']==2) selected @endif  value="2">نص جملة</option>
         <option  @if($invoice_data['sales_item_type']==3) selected @endif  value="3">جملة</option>
         </select>
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
         <div class="form-group">
            <label>   بيانات العملاء
            (<a id="load_add_new_customer" title=" اضافة عميل جديد " href="#">جديد <i   class="fa fa-plus-circle  "></i> </a>) 
            </label>
            <input type="text" class="form-control" id="searchbytextforcustomerInupdate" placeholder="اسم العميل - كود العميل">
            <div id="searchbytextforcustomerDiv">
               <select name="customer_code" id="customer_code" class="form-control ">
                  <option value=""> لايوجد عميل</option>
                  @if (@isset($customers) && !@empty($customers))
                  @foreach ($customers as $info )
                  <option @if($invoice_data['customer_code']==$info->customer_code and $invoice_data['is_has_customer']==1) selected @endif  value="{{ $info->customer_code }}"> {{ $info->name }} </option>
                  @endforeach
                  @endif
               </select>
            </div>
         </div>
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
            @php $i=1;  @endphp
            @foreach ($stores as $info )
            <option @if($i==1) selected @endif value="{{ $info->id }}"> {{ $info->name }} </option>
            @php $i++;  @endphp
            @endforeach
            @endif
         </select>
      </div>
   </div>
   <div class="col-md-3" >
      <div class="form-group">
         <label>    نوع البيع</label>
         <select disabled name="sales_item_type" id="sales_item_type" class="form-control ">
         <option @if($invoice_data['sales_item_type']==1) selected @endif value="1">قطاعي</option>
         <option  @if($invoice_data['sales_item_type']==2) selected @endif  value="2">نص جملة</option>
         <option  @if($invoice_data['sales_item_type']==3) selected @endif  value="3">جملة</option>
         </select>
      </div>
   </div>
   <div class="col-md-3">
      <div class="form-group">
         <input type="radio" checked value="1" name="searchforitemRadioType"> بحث بالقارئ
         <input type="radio" value="2" name="searchforitemRadioType"> بحث يدوي
         <input id="searchforitem" class="form-control" type="text" placeholder=" باركود - اسم" >
         <div id="searchforitemresultDiv">
            <select  id="item_code" name="item_code" class="form-control " style="width: 100%;">
               <option value="">اختر الصنف</option>
            </select>
         </div>
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
      <button style="margin-top:35px" class="btn btn-sm btn-success" id="AddItemToIvoiceDetailsActive">أضف الصنف فعليا </button>  
   </div>
</div>
<div class="clearfix"></div>
<hr style="border:1px solid #3c8dbc;">
<div class="row" id="activeItemisInInvoiceDiv">
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
         @if(!@empty($sales_invoices_details))
         @foreach ($sales_invoices_details as $info )
         <tr>
            <td>
               {{ $info->store_name }}
               <input type="hidden" name="item_total_array[]" class="item_total_array" value="{{$info->total_price}}">
            </td>
            <td>
               @if($info->sales_item_type==1) قطاعي   @elseif($info->sales_item_type==2) نص جملة @elseif($info->sales_item_type==3) جملة @else  لم يحدد @endif
            </td>
            <td>{{ $info->item_name }}</td>
            <td>{{ $info->uom_name }}</td>
            <td>{{ $info->unit_price*1 }}</td>
            <td>{{ $info->quantity*1 }}</td>
            <td>{{ $info->total_price*1 }}</td>
            <td>
               <button  data-id="{{ $info->id }}" class="btn remove_active_row_item are_you_shue btn-sm btn-danger">حذف</button>  
            </td>
         </tr>
         @endforeach
         @endif
      </tbody>
   </table>
</div>
<div class="clearfix"></div>
<hr style="border:1px solid #3c8dbc;">
<div class="row">
   <div class="col-md-3">
      <div class="form-group">
         <label>اجمالي الاصناف  </label>
         <input readonly oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="total_cost_items"  id="total_cost_items" 
            class="form-control"  value="{{ $invoice_data['total_cost_items']*1 }}"  >
      </div>
   </div>
   <div class="col-md-3">
      <div class="form-group">
         <label>    نسبة الضريبة </label>
         <input  oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="tax_percent"  id="tax_percent" 
            class="form-control"  value="{{ $invoice_data['tax_percent']*1 }}"  >
      </div>
   </div>
   <div class="col-md-3">
      <div class="form-group">
         <label>  قيمة الضريبة   </label>
         <input readonly    id="tax_value" class="form-control"  name="tax_value" value="{{ $invoice_data['tax_value']*1 }}"  >
      </div>
   </div>
   <div class="col-md-3">
      <div class="form-group">
         <label>     الاجمالي قبل الخصم </label>
         <input readonly    id="total_befor_discount" name="total_befor_discount" class="form-control"  
            value="{{ $invoice_data['total_befor_discount']*1 }}"  >
      </div>
   </div>
   <div class="col-md-3">
      <div class="form-group">
         <label>     نوع الخصم   </label>
         <select class="form-control" name="discount_type" id="discount_type">
            <option value="">لايوجد خصم</option>
            <option @if($invoice_data['discount_type']==1) selected @endif value="1" >    نسبة مئوية</option>
            <option @if($invoice_data['discount_type']==2) selected @endif value="2" > قيمة يدوي</option>
         </select>
      </div>
   </div>
   <div class="col-md-3">
      <div class="form-group">
         <label>     نسبة  الخصم </label>
         <input @if($invoice_data['discount_type']=="" || $invoice_data['discount_type']==null) readonly @endif    oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="discount_percent"  id="discount_percent" class="form-control"  value="{{ $invoice_data['discount_percent']*1 }}"  >
      </div>
   </div>
   <div class="col-md-3">
      <div class="form-group">
         <label>  قيمة   الخصم   </label>
         <input readonly  name="discount_value"   id="discount_value" class="form-control"  value="{{ $invoice_data['discount_value']*1 }}"  >
      </div>
   </div>
   <div class="col-md-3">
      <div class="form-group">
         <label>     الاجمالي النهائي       </label>
         <input readonly name="total_cost"    id="total_cost" class="form-control"  value="{{ $invoice_data['total_cost']*1 }}"  >
      </div>
   </div>
</div>
<div class="row" id="shiftDiv">
   <div class="col-md-3">
      <div class="form-group">
         <label>    خزنة التحصيل  </label>
         <select id="treasuries_id" name="treasuries_id" class="form-control">
            @if(!@empty($user_shift))
            <option selected value="{{ $user_shift['treasuries_id']  }}"> {{ $user_shift['name'] }} </option>
            @else
            <option value=""> عفوا لاتوجد خزنة لديك الان</option>
            @endif
         </select>
      </div>
   </div>
   <div class="col-md-3 > 
      <div class="form-group">
      <label>  الرصيد المتاح بالخزنة   </label>
      <input  readonly name="treasuries_balance" id="treasuries_balance" class="form-control" 
      @if(!@empty($user_shift))
      value="{{ $user_shift['balance']*1 }}" 
      @else
      value="0" 
      @endif
      >
   </div>
</div>
<div class="row">
   <div class="col-md-3">
      <div class="form-group">
         <label>     نوع الفاتورة   </label>
         <select class="form-control" name="pill_type" id="pill_type">
         <option value="1"  @if($invoice_data['pill_type']==1) selected @endif value="1"  >     كاش</option>
         <option value="2"  @if($invoice_data['pill_type']==2) selected @endif value="2" >  اجل</option>
         </select>
      </div>
   </div>
   <div class="col-md-3 > 
      <div class="form-group">
      <label>    المحصل  الان   </label>
      <input   name="what_paid" id="what_paid" class="form-control"  @if($invoice_data['pill_type']==1)  readonly  @endif"  value="@if($invoice_data['pill_type']==1) {{$invoice_data['total_cost']*1  }} @else 0 @endif"    >
   </div>
   <div class="col-md-3 > 
      <div class="form-group">
      <label>    المتبقي تحصيله    </label>
      <input readonly   name="what_remain" id="what_remain" class="form-control"   value="@if($invoice_data['pill_type']==1) 0 @else {{$invoice_data['what_remain']*1  }}  @endif"     >
   </div>
   <div class="col-md-6 ">
      <div class="form-group">
         <label>      الملاحظات علي الفاتورة   </label>
         <input  style="background-color: lightgoldenrodyellow"    name="notes" id="notes" class="form-control"   value="{{ $invoice_data['notes'] }}"    >
      </div>
   </div>
   <div class="col-md-6 text-left"> 
      <button class="btn btn-sm btn-primary" id="DoApproveInvoiceFinally" style="margin-top:31px;">اعتماد وترحيل الفاتورة</button>
   </div>
</div>
@section("script")
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script>
   //Initialize Select2 Elements
   $('.select2').select2({
     theme: 'bootstrap4'
   });
</script>
@endsection
@else
<div class="alert alert-danger">
   عفوا لايمكن التعديل علي فاتورة معتمده وتم ترحيلها !!!!
</div>
@endif