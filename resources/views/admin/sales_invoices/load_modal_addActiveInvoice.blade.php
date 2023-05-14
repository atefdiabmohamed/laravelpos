@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
<div class="row">
   <div class="col-md-3">
      <div class="form-group"> 
         <label>    تاريخ الفاتورة</label>
         <input type="date" name="invoice_date" id="invoice_date_activeAdd" class="form-control" value="@php echo date("Y-m-d"); @endphp">
      </div>
   </div>
   <div class="col-md-3" >
      <div class="form-group">
         <label>    نوع  البيع</label>
         <select  name="sales_item_type_main" id="sales_item_type_main" class="form-control ">
            <option value="1">قطاعي</option>
            <option value="2">نص جملة</option>
            <option value="3">جملة</option>
         </select>
      </div>
   </div>
   <div class="col-md-3" >
      <div class="form-group">
         <label>    فئات الفواتير</label>
         <select name="Sales_matrial_types_id" id="Sales_matrial_types_id_activeAdd" class="form-control select2">
            <option value="">  اختر فئة الفاتورة</option>
            @if (@isset($Sales_matrial_types) && !@empty($delegates))
            @php $i=1; @endphp
            @foreach ($Sales_matrial_types as $info )
            <option @if($i==1) selected @endif  value="{{ $info->id }}"> {{ $info->name }} </option>
            @php $i++;  @endphp
            @endforeach
            @endif
         </select>
      </div>
   </div>
   <div class="col-md-3">
      <div class="form-group">
         <label>     نوع الدفع   </label>
         <select class="form-control" name="pill_type" id="pill_type_activeAdd">
            <option value="1"   >     كاش</option>
            <option value="2"  >  اجل</option>
         </select>
      </div>
   </div>
   <div class="col-md-3">
      <div class="form-group">
         <label>      هل يوجد عميل</label>
         <select name="is_has_customer" id="is_has_customer" class="form-control" >
            <option value="1" selected> نعم  عميل</option>
            <option value="0" > لايوجد عميل( طياري )</option>
         </select>
      </div>
   </div>
   <div class="col-md-6" id="customer_codeDiv" >
      <div class="form-group">
         <div class="form-group">
            <label>   بيانات العملاء
            (<a id="load_add_new_customer" title=" اضافة عميل جديد " href="#">جديد <i   class="fa fa-plus-circle  "></i> </a>) 
            </label>
            <input type="text"  class="form-control" id="searchbytextforcustomer" placeholder="اسم العميل - كود العميل">
            <div id="searchbytextforcustomerDiv">
               <select name="customer_code" id="customer_code" class="form-control ">
                  <option value=""> لايوجد عميل</option>
               </select>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-3" >
      <div class="form-group">
         <label>   بيانات المناديب</label>
         <select name="delegate_code" id="delegate_code_activeAdd" class="form-control select2">
            <option value="">  اختر المندوب</option>
            @if (@isset($delegates) && !@empty($delegates))
            @php $i=1; @endphp
            @foreach ($delegates as $info )
            <option   @if($i==1) selected @endif  value="{{ $info->delegate_code }}"> {{ $info->name }} </option>
            @php $i++;  @endphp
            @endforeach
            @endif
         </select>
      </div>
   </div>
  
   <div class="col-md-12 text-center" >
      <hr>
      <button type="submit" id="Do_Add_new_active_invoice"  class="btn btn-sm btn-success">      اضف الفاتورة (فتح فاتورة جديدة فعلية) </button>
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