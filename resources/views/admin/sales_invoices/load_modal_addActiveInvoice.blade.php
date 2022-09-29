@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection
                <div class="row">
                  <div class="col-md-4">
                   <div class="form-group"> 
                     <label>    تاريخ الفاتورة</label>
                    <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="@php echo date("Y-m-d"); @endphp">
                     </div>
                  </div>
                  <div class="col-md-4" >
                    <div class="form-group"> 
                     <label>    فئات الفواتير</label>
                     <select name="Sales_matrial_types_id" id="Sales_matrial_types_id" class="form-control select2">
                       <option value="">  اختر فئة الفاتورة</option>
                       @if (@isset($Sales_matrial_types) && !@empty($delegates))
                      @foreach ($Sales_matrial_types as $info )
                        <option  value="{{ $info->id }}"> {{ $info->name }} </option>
                      @endforeach
                       @endif
                     </select>
                   
                     </div>
 
                   </div>
                  <div class="col-md-4">
                    <div class="form-group"> 
                      <label>      هل يوجد عميل</label>
             <select name="is_has_customer" id="is_has_customer" class="form-control" >
             <option value="1" selected> نعم  عميل</option>
             <option value="0" > لايوجد عميل( طياري )</option>

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
                       <option  value="{{ $info->customer_code }}"> {{ $info->name }} </option>
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
                        <option  value="{{ $info->delegate_code }}"> {{ $info->name }} </option>
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
                


  
              
              
