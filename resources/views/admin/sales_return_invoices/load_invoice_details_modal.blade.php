<div class="row">
  <div class="col-md-4">
     <div class="form-group"> 
        <label>    تاريخ الفاتورة</label>
        <input readonly type="date"  class="form-control" value="{{ $invoice_data['invoice_date'] }}">
     </div>
  </div>
  <div class="col-md-4" >
     <div class="form-group">
        <label>    فئات الفواتير</label>
        <select disabled  class="form-control ">
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
        <select disabled  class="form-control" >
        <option @if($invoice_data['is_has_customer']==1) selected @endif value="1" selected> نعم  عميل</option>
        <option @if($invoice_data['is_has_customer']==0) selected @endif value="0" > لايوجد عميل( طياري )</option>
        </select>
     </div>
  </div>
  <div class="col-md-4"  >
     <div class="form-group">
        <label>   بيانات العملاء
        </label>
        <select disabled  class="form-control select2">
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
        <select disabled  class="form-control select2">
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
<div class="clearfix"></div>
<hr style="border:1px solid #3c8dbc;">
<div class="row" >
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
     </thead>
     <tbody >
        @if(!@empty($sales_invoices_details))
        @foreach ($sales_invoices_details as $info )
        <tr>
           <td>
              {{ $info->store_name }}
           </td>
           <td>
              @if($info->sales_item_type==1) قطاعي   @elseif($info->sales_item_type==2) نص جملة @elseif($info->sales_item_type==3) جملة @else  لم يحدد @endif
           </td>
           <td>{{ $info->item_name }}</td>
           <td>{{ $info->uom_name }}</td>
           <td>{{ $info->unit_price*1 }}</td>
           <td>{{ $info->quantity*1 }}</td>
           <td>{{ $info->total_price*1 }}</td>
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
        <input readonly oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  
           class="form-control"  value="{{ $invoice_data['total_cost_items']*1 }}"  >
     </div>
  </div>
  <div class="col-md-3">
     <div class="form-group">
        <label>    نسبة الضريبة </label>
        <input readonly  oninput="this.value=this.value.replace(/[^0-9.]/g,'');" 
           class="form-control"  value="{{ $invoice_data['tax_percent']*1 }}"  >
     </div>
  </div>
  <div class="col-md-3">
     <div class="form-group">
        <label>  قيمة الضريبة   </label>
        <input readonly    class="form-control"  value="{{ $invoice_data['tax_value']*1 }}"  >
     </div>
  </div>
  <div class="col-md-3">
     <div class="form-group">
        <label>     الاجمالي قبل الخصم </label>
        <input readonly     class="form-control"  
           value="{{ $invoice_data['total_befor_discount']*1 }}"  >
     </div>
  </div>
  <div class="col-md-3">
     <div class="form-group">
        <label>     نوع الخصم   </label>
        <select disabled class="form-control" >
           <option value="">لايوجد خصم</option>
           <option @if($invoice_data['discount_type']==1) selected @endif value="1" >    نسبة مئوية</option>
           <option @if($invoice_data['discount_type']==2) selected @endif value="2" > قيمة يدوي</option>
        </select>
     </div>
  </div>
  <div class="col-md-3">
     <div class="form-group">
        <label>     نسبة  الخصم </label>
        <input readonly   oninput="this.value=this.value.replace(/[^0-9.]/g,'');"  class="form-control"  value="{{ $invoice_data['discount_percent']*1 }}"  >
     </div>
  </div>
  <div class="col-md-3">
     <div class="form-group">
        <label>  قيمة   الخصم   </label>
        <input readonly   class="form-control"  value="{{ $invoice_data['discount_value']*1 }}"  >
     </div>
  </div>
  <div class="col-md-3">
     <div class="form-group">
        <label>     الاجمالي النهائي       </label>
        <input readonly  class="form-control"    value="{{ $invoice_data['total_cost']*1 }}"  >
     </div>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
     <div class="form-group">
        <label>     نوع الفاتورة   </label>
        <select disabled class="form-control" >
        <option value="1"  @if($invoice_data['pill_type']==1) selected @endif value="1"  >     كاش</option>
        <option value="2"  @if($invoice_data['pill_type']==2) selected @endif value="2" >  اجل</option>
        </select>
     </div>
  </div>
  <div class="col-md-3 > 
     <div class="form-group">
     <label>    المحصل لحظتها   </label>
     <input   readonly class="form-control"   value="{{$invoice_data['what_paid']*1  }}"     >
  </div>
  <div class="col-md-3 > 
     <div class="form-group">
     <label>    الاجل المتبقي تحصيله    </label>
     <input readonly    class="form-control"  value="{{$invoice_data['what_remain']*1  }}"     >
  </div>
  <div class="col-md-6 ">
     <div class="form-group">
        <label>      الملاحظات علي الفاتورة   </label>
        <input  readonly style="background-color: lightgoldenrodyellow"    
           class="form-control"   value="{{ $invoice_data['notes'] }}"    >
     </div>
  </div>
</div>